<?php

namespace api\controllers;


use yii\filters\AccessControl;
use api\behaviours\Verbcheck;
use api\behaviours\Apiauth;
use frontend\models\Folder;
use api\models\UserSearch;
use frontend\models\Person;
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
			$folderDetails[$firstFolderFilter['id']]['createdby'] = $firstFolderFilter->folderManagerByRole['user_id'];
		}
		$folders[] = $folderDetails;
        $response = $folders;
        Yii::$app->api->sendSuccessResponse([$response]);
		
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
			$folderDetails['subfolders'] = $folder->subFolders;
			$folders[] =   $folderDetails;

			$response = $folders;
			Yii::$app->api->sendSuccessResponse($response);
		}else{
			$response = ['somthing went wrong'];
			Yii::$app->api->sendFailedResponse($response);
		}
		
		
    }
	
	public function actionSubfolder($id)
    {
        $folder = Folder::find()->andWhere(['id' => $id])->one();
		if(!empty($folder)){
			$folderDetails['parent_details']['total_task'] = count($folder->clipOn['task']);
			$folderDetails['parent_details']['users'] = count($folder->users);
			$i = 1;
			foreach ($folder->clipOn['task'] as $key => $completed) {
				if($completed->status_id == 24){
					 $i++;
				 }
			 }
			$folderDetails['parent_details']['completed_task'] = $i;
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
			$folders['subfolders'] = $folderDetails;
			$response = $folders;
			Yii::$app->api->sendSuccessResponse([$response]);
		}else{
			$response = ['there are no subfolders'];
			Yii::$app->api->sendFailedResponse($response);
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
						Yii::$app->api->sendSuccessResponse($model->attributes,$response);
					} else{
						Yii::$app->api->sendFailedResponse(['didnot create']);
					}

				}
        	}
			

		}else{
			Yii::$app->api->sendFailedResponse(['you dont have access to this folder']);
		}
        
	}

   public function actionCreate()
    {
        $model = new Folder();
		$model->attributes = $this->request;
        if (!empty($model->attributes['title'])) {
			$model->last_updated =  new Expression('NOW()');
			if($model->save()){
            	Yii::$app->api->sendSuccessResponse($model->attributes);
			}
            
        }else{
			if (!$model->validate()) {

            Yii::$app->api->sendFailedResponse($model->errors);
        }
			
		}

        
    }


    public function actionUpdate($id)
    {
		
        $model =  $this->findModel($id);
		$model->attributes = $this->request;
		if(!empty($model)){
			if ($model->save()) {
			   Yii::$app->api->sendSuccessResponse($model->attributes);
			}else{
				Yii::$app->api->sendFailedResponse(['could not create']);
			}
		}else{
			Yii::$app->api->sendFailedResponse(['you dont have access to this folder']);
		}
        
	}
	
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->api->sendSuccessResponse($model->attributes);
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
			
			
			foreach($folderManager as $managerKey => $managerValue){
				
				if($userValue->id == $managerValue->user_id){
					
					$folderUsers[$i]['role'] = $managerValue->role;
					$folderUsers[$i]['folder_id'] = $managerValue->folder_id;
				}
			}
			
			$i++;
		}
		Yii::$app->api->sendSuccessResponse($folderUsers);
    }
	
	public function actionUsers() {
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
				Yii::$app->api->sendSuccessResponse($userDetails);
			}else{
				Yii::$app->api->sendFailedResponse(['no result was found']);
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
		
		if($folderManagerModel->save(false)){
			//return $folderModel->parent_id > 0? $this->addFolderNewUser($userId,$folderModel->parent_id ):true;
			return true;
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
				Yii::$app->api->sendSuccessResponse(['delete was successfull']);
			}else{
				Yii::$app->api->sendFailedResponse(['somthing went wrong pls try again ']);
			}
		}else{
			Yii::$app->api->sendFailedResponse(['you dont have access to delete a user in this  folder']);
		}
		
    }

    protected function findModel($id)
    {
        if (($model = Folder::findOne($id)) !== null) {
            return $model;
        } else {
            Yii::$app->api->sendFailedResponse("Invalid Record requested");
        }
    }
}