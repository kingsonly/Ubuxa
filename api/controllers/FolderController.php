<?php

namespace api\controllers;


use yii\filters\AccessControl;
use api\behaviours\Verbcheck;
use api\behaviours\Apiauth;
use frontend\models\Folder;
use api\models\UserSearch;
use frontend\models\Person;
use frontend\models\UserDb;
use frontend\models\FolderManager;
use yii\web\UploadedFile;
use Yii;
use yii\db\Expression;



class FolderController extends RestController
{

    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [

           'apiauth' => [
               'class' => Apiauth::className(),
               'exclude' => ['users'],
               'callback'=>[]
           ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [
                            'index'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['*'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'index' => ['GET', 'POST'],
                    'create' => ['POST'],
                    'update' => ['PUT'],
                    'view' => ['GET'],
                    'delete' => ['DELETE']
                ],
            ],

        ];
    }

    public function actionIndex()
    {
        $folder = Folder::find()->all();
		$seperateFolders = array();
		foreach ($folder as $key => $firstFolderFilter) {
			if($firstFolderFilter->private_folder == $firstFolderFilter::DEFAULT_PRIVATE_FOLDER_STATUS){
				$folderStatus = 'public';
			}else{
				$folderStatus = 'private';
			}
			
			$folderDetails[$firstFolderFilter['id']]  =  $firstFolderFilter['attributes'];
			$folderDetails[$firstFolderFilter['id']]['folderstatus'] = $folderStatus;
			$folderRole = $firstFolderFilter['role'];
			$folderDetails[$firstFolderFilter['id']]['role'] =  $folderRole['role'];
			$folderDetails[$firstFolderFilter['id']]['createdby'] = $firstFolderFilter->folderManagerByRole['user_id'];
		}
		array_walk_recursive($folderDetails,function(&$item){$item=strval($item);});
		$folders[] = $folderDetails;
        $response = $folders;
        return Yii::$app->apis->sendSuccessResponse([$response]);
		
    }
	
	public function actionFolderDetails($id)
    {
        $folder = Folder::find()->andWhere(['id' => $id])->one();
		if(!empty($folder)){
			if($folder->private_folder == $folder::DEFAULT_PRIVATE_FOLDER_STATUS){
			$folderStatus = 'public';
			}else{
				$folderStatus = 'private';
			}
			$folderDetails = (array) $folder->attributes;
			$folderDetails['folderstatus'] = $folderStatus;
			$folderRole = $folder['role'];
			$folderDetails['role'] =  $folderRole['role'];
			$folderDetails['createdby'] = $folder->folderManagerByRole['user_id'];
			$userId = $folder->folderManagerByRole['user_id'];
			$user = UserDb::find()->andWhere(['id' => $userId])->one();
			$fullName = $user->fullName;
			$folderDetails['fullname'] = $fullName;
			$folderDetails['subfolders'] = $folder->subFolders;
			$folders[] =   $folderDetails;
			//array_walk_recursive($folders,function(&$item){$item=strval($item);});
			$response = $folders;
			return Yii::$app->apis->sendSuccessResponse($response);
		}else{
			$response = ['somthing went wrong'];
			return Yii::$app->apis->sendFailedResponse($response);
		}
		
		
    }
	
	public function actionSubfolder($id)
    {
        $folder = Folder::find()->andWhere(['id' => $id])->one();
		if(!empty($folder)){
			$folders['parent_details']['users'] = count($folder->users);
			$i = 0;
			if(!empty($folder->clipOn['task'])){
				$folders['parent_details']['total_task'] = count($folder->clipOn['task']);
				foreach ($folder->clipOn['task'] as $key => $completed) {
					if($completed->status_id == 24){
						 $i++;
					 }
				 }
				$folders['parent_details']['completed_task'] = $i;
			}else{
				$folders['parent_details']['total_task'] = 0;
				$folders['parent_details']['completed_task'] = 0;
			}
			if(!empty($folder->subFolders)){
				foreach ($folder->subFolders as $key => $firstFolderFilter) {
					if($firstFolderFilter->private_folder == $firstFolderFilter::DEFAULT_PRIVATE_FOLDER_STATUS){
						$folderStatus = 'public';
					}else{
						$folderStatus = 'private';
					}
				
					$folderDetails[$firstFolderFilter['id']]  =  $firstFolderFilter['attributes'];
					$folderDetails[$firstFolderFilter['id']]['folderstatus'] = $folderStatus;
					$folderRole = $firstFolderFilter['role'];
					$folderDetails[$firstFolderFilter['id']]['role'] =  $folderRole['role'];
					$folderDetails[$firstFolderFilter['id']]['createdby'] = $firstFolderFilter->folderManagerByRole['user_id'];
				}
				array_walk_recursive($folderDetails,function(&$item){$item=strval($item);});
				$folders['subfolders'] = $folderDetails;
				$response = $folders;
				return Yii::$app->apis->sendSuccessResponse([$response]);
			}else{
				return Yii::$app->apis->sendFailedResponse('There are no subfolders');
			}
		}else{
			return Yii::$app->apis->sendFailedResponse($response);
		}
		
		
    }
	
	
	public function actionUpdateFolderImage($id)
    {
		
        $model =  $this->findModel($id);
		$model->controlerLocation = 'API';
		$model->attributes = $this->request;
		if(!empty($model)){
			if (Yii::$app->request->isPost) {
				$model->upload_file = UploadedFile::getInstanceByName('upload_file');
				
				if ($model->upload()) {
					
					// file is uploaded successfully
					if($model->save()){
						$response = ['msg' => 'created'];
						return Yii::$app->apis->sendSuccessResponse($model->attributes,$response);
					} else{
						return Yii::$app->apis->sendFailedResponse(['did not create']);
					}

				}
        	}
			

		}else{
			return Yii::$app->apis->sendFailedResponse(['you dont have access to this folder']);
		}
        
	}

   public function actionCreate()
    {
        $model = new Folder();
		$model->attributes = $this->request;
        if (!empty($model->attributes['title'])) {
			$model->last_updated =  new Expression('NOW()');
			if($model->save()){
            	return Yii::$app->apis->sendSuccessResponse($model->attributes);
			}
            
        }else{
			if (!$model->validate()) {

            return Yii::$app->apis->sendFailedResponse($model->errors);
        }
			
		}

        
    }


    public function actionUpdate($id)
    {
		
        $model =  $this->findModel($id);
		$model->attributes = $this->request;
		if(!empty($model)){
			if ($model->save()) {
			   return Yii::$app->apis->sendSuccessResponse($model->attributes);
			}else{
				return Yii::$app->apis->sendFailedResponse(['could not create']);
			}
		}else{
			return Yii::$app->apis->sendFailedResponse(['you dont have access to this folder']);
		}
        
	}
	
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		if(empty($model)){
			return Yii::$app->apis->sendFailedResponse('task does not exist');
		}else{
			if($model->delete()){
        		return Yii::$app->apis->sendSuccessResponse($model->attributes);
			}else{
				if (!$model->validate()) {
					return Yii::$app->apis->sendFailedResponse($model->errors);
				}
			}
		}
    }
	
	public function actionFolderUsers($id)
    {
		
		$model = $this->findModel($id);
		$users = $model->users;
		$folderManager = $model->folderManager;
		$folderUsers = [];
		$i = 0;
		foreach($users as $userKey => $userValue){
			foreach($userValue as $key => $value){
				$folderUsers[$i][$key] = $value;
			}
			$user = UserDb::find()->andWhere(['id' => $userValue->id])->one();
			$fullName = $user->fullName;
			$folderUsers[$i]['fullName'] = $fullName;
			
			foreach($folderManager as $managerKey => $managerValue){
				
				if($userValue->id == $managerValue->user_id){
					
					$folderUsers[$i]['role'] = $managerValue->role;
					$folderUsers[$i]['images'] = !empty($userValue->profile_image)?'http://ubuxa.net/'.$userValue->profile_image:'http://ubuxa.net/images/users/default-user.png';
					$folderUsers[$i]['folder_id'] = $managerValue->folder_id;
				}
			}
			
			$i++;
		}
		//array_walk_recursive($folderUsers,function(&$item){$item=strval($item);});
		return Yii::$app->apis->sendSuccessResponse($folderUsers);
    }
	
	public function actionUsers() 
	{
		$model = new UserSearch();
		$model->attributes = $this->request;
		if (!$model->validate()) {

            Yii::$app->api->sendFailedResponse($model->errors);
            //return null;
        }
		if (!is_null($model->search_string)) {
			$query = new Person();
			$allUsers = $query->find()
				->andWhere(['like', 'first_name', $model->search_string])->orWhere(['cid' =>yii::$app->user->identity->cid])->orWhere(['like', 'surname', $model->search_string])->all();
			$userDetails = [];
			if(!is_null($allUsers)){
				foreach($allUsers as $key => $value){
					$userDetails[$key]['first_name'] = $value->first_name;
					$userDetails[$key]['id'] = $value->id;
					$userDetails[$key]['userid'] = $value->user['id'];
				}
				return Yii::$app->apis->sendSuccessResponse($userDetails);
			}else{
				return Yii::$app->apis->sendFailedResponse(['no result was found']);
			}
			
		}
		
		
	}
	
	public function actionAddUserToFolder($userId = '', $folderId = '')
	{
		$folderModel = Folder::find()->andWhere(['id'=>$folderId])->one();
		$folderManagerModel = new FolderManager();
		$folderManagerModel->user_id = $userId;
		$folderManagerModel->folder_id = $folderId;
		$folderManagerModel->role = 'user';
		$user = UserDb::findOne($userId);
		$profile_image = $user->profile_image;
		$fullname = $user->fullName;
		$folderManager['id'] = $userId;
		$folderManager['fullName'] = $fullname;
		$folderManager['profile_image'] = $profile_image;
		$folderManager['folder_id'] = $folderId;
		$folderManager['role'] = $folderManagerModel->role;
		
		if($folderManagerModel->save(false)){
			//return $folderModel->parent_id > 0? $this->addFolderNewUser($userId,$folderModel->parent_id ):true;
			return $folderManager;
		}
	}
	
	
	public function actionDeleteUsers($folderid,$userid)
    {
       
		$folderId =  $folderid;
		$userId =  $userid;
		$userIdentityRole = yii::$app->user->identity->roleName;
		$userIdentityId = yii::$app->user->identity->id;
		$folderManager = FolderManager::find()->select('role')->andWhere(['folder_id'=>$folderId,'user_id' => $userIdentityId])->one();
		// use identity of the user to determine if the user has access to delete a folder or not 
		if($folderManager->role == 'author' or $userIdentityRole == 'admin' or $userIdentityRole == 'manager'){
			$folderManagerModel = new FolderManager();
			$findFolderUser = $folderManagerModel->find()->andWhere(['folder_id' => $folderId, 'user_id' => $userId])->one();
			if($findFolderUser->delete()){
				return Yii::$app->apis->sendSuccessResponse(['delete was successfull']);
			}else{
				return Yii::$app->apis->sendFailedResponse(['somthing went wrong pls try again ']);
			}
		}else{
			return Yii::$app->apis->sendFailedResponse(['you dont have access to delete a user in this  folder']);
		}
		
    }

    protected function findModel($id)
    {
        if (($model = Folder::findOne($id)) !== null) {
            return $model;
        } else {
            return Yii::$app->apis->sendFailedResponse("Invalid Record requested");
        }
    }
}