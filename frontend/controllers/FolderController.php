<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Folder;
use frontend\models\FolderManager;
use frontend\models\Person;
use frontend\models\InviteUsers;
use frontend\models\Task;
use frontend\models\Remark;
use frontend\models\StatusType;
use frontend\models\Reminder;
use frontend\models\Label;
use frontend\models\TaskLabel;
use frontend\models\Onboarding;
use frontend\models\TaskAssignedUser;
use frontend\models\UserDb;
use frontend\models\UserFeedback;
use frontend\models\Component;
use frontend\models\Edocument;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\UploadedFile;
use \boffins_vendor\queue\FolderUsersQueue;
use boffins_vendor\classes\BoffinsBaseController;



/**
 * FolderController implements the CRUD actions for Folder model.
 */
class FolderController extends BoffinsBaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Folder models.
     * @return mixed
     */
    public function actionIndex()
    {
       	$folder = Folder::find()->all();
		$seperateFolders = array();
		foreach ($folder as $firstFolderFilter) {
			if($firstFolderFilter->private_folder == $firstFolderFilter::DEFAULT_PRIVATE_FOLDER_STATUS){
				$folderStatus = 'public';
			}else{
				$folderStatus = 'private';
			}
			if($firstFolderFilter->parent_id > $firstFolderFilter::DEFAULT_FOLDER_PARENT_STATUS){
				$CheckParentfolderAccess = Folder::findOne(['id' => $firstFolderFilter->parent_id ]); 
			}
			if($firstFolderFilter->parent_id == $firstFolderFilter::DEFAULT_FOLDER_PARENT_STATUS ){
				if($firstFolderFilter->folderManagerFilter->role == 'author'){
					$seperateFolders['root folder'][$folderStatus][] = $firstFolderFilter;
				}else{
					$seperateFolders['root folder']['shared'][] = $firstFolderFilter;
				}
			} else{
				if($firstFolderFilter->folderManagerFilter->role == 'author'){
				
					$seperateFolders['sub folder'][$folderStatus][] = $firstFolderFilter;
				}else{
					$seperateFolders['sub folder']['shared'][] = $firstFolderFilter;
				}
			}
			

		}
		if(empty($folder)){
            return $this->render('empty_index');
        } else {
            return $this->render('index', [
            'folders' => $seperateFolders,
            ]);
        }
        
    }

	public function actionIndex2()
    {
       	$folder = Folder::find()->all();
		if(empty($folder)){
            return $this->render('empty_index');
        } else {
            return $this->render('empty_index', [
            'folders' => $folder,
            ]);
        }

	}

    /**
     * Displays a single Folder model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		//Yii::$app->formatter->nullDisplay = 'N\A';
		$model = $this->findModel($id);
        $task = new Task();
		$remark = new Remark();
        $taskStatus = StatusType::find()->where(['status_group' => 'task'])->all();
        $reminder = new Reminder();
        $label = new label();
        $feedback = new UserFeedback();
        $componentModel = new Component();
        $taskLabel = new TaskLabel();
        $taskAssignedUser = new TaskAssignedUser();
        $cid = Yii::$app->user->identity->cid;
        $userId = Yii::$app->user->identity->id;
        $users = $model->users;
		$componentCreateUrl = Url::to(['component/create']);
        $onboardingExists = Onboarding::find()->where(['user_id' => $userId])->exists(); 
        $onboarding = Onboarding::find()->andWhere(['user_id' => $userId])->one();
        $edocument = Edocument::find()->where(['reference'=>'folder','reference_id'=>$id])->all();
        
		if (isset($_POST['hasEditable'])) {
        // use Yii's response format to encode output as JSON
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // read your posted model attributes
        if ($model->load(Yii::$app->request->post())) {
            // read or convert your posted information
            
            $model->save(false);
            // return JSON encoded output in the below format
            return ['output'=>'', 'message'=>''];
            
            // alternatively you can return a validation error
            // return ['output'=>'', 'message'=>'Validation error'];
        }
        // else if nothing to do always return an empty JSON encoded output
        else {
            return ['output'=>'', 'message'=>''];
        }
    }
		
        return $this->render('view', [
            'model' => $model,
            'task' => $task,
            'taskModel' => $task,
            'feedback' => $feedback,
			'remarkModel' => $remark,
		    'taskStatus' => $taskStatus,
            'reminder' => $reminder,
            'label' => $label,
            'taskLabel' => $taskLabel,
            'taskAssignedUser' => $taskAssignedUser,
            'users' => $users,
            'userId' => $userId,
            'id' => $id,
            'componentCreateUrl' => $componentCreateUrl,
            'componentModel' => $componentModel,
            'onboardingExists' => $onboardingExists,
            'onboarding' => $onboarding,
            'edocument' => $edocument,
        ]);
    }
	
	public function actionUsers($q = null, $id = null) {
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$out = ['results' => ['id' => '', 'text' => '']];
		if (!is_null($q)) {
			$query = new Person();
			$allUsers = $query->find()->select('id, first_name, surname')
				->andWhere(['like', 'first_name', $q])->orWhere(['like', 'surname', $q])->all();
			
			$out['results'] = array_values($allUsers);
		}
		elseif ($id > 0) {
			$out['results'] = ['id' => 0, 'first_name' => 'could not find ','surname' => 'a any user'];
		}
		return $out;
	}
	
	public function actionNewMessage() {
		$folderId = $_REQUEST['folderId']; // post params from ajax call
		$username = $_REQUEST['userName'];
		$folder = Folder::find()->andWhere(['id' => $folderId])->select('title')->one();
		$user = UserDb::find()->andWhere(['username' => $username])->one();
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$out = ['name'=>$user->fullname,'folder' => $folder['title']];
		
		return $out;
	}
	
	public function actionAddUsers($id) {
		$inviteUsersModel = new InviteUsers();
		$userModel = new UserDb();
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		 if ($inviteUsersModel->load(Yii::$app->request->post())) {
			  
			 foreach($inviteUsersModel->users as $value){
				 $getUserId = $userModel->find()->select(['id'])->where(['person_id' => $value])->one();
				 /*
				 $test = $getUserId['id'];
				 Yii::$app->queue->push(new FolderUsersQueue([
					'userId' => $getUserId['id'],
					'folderId' => $id,
					'type' => 'folder',
				]));
				 */
				 $this->addFolderNewUser($getUserId['id'], $id);
			 }
            return ['output'=>$id, 'message'=> 0];
        }
	}

    /**
     * Creates a new Folder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Folder();
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($model->load(Yii::$app->request->post())) {
			$model->last_updated =  new Expression('NOW()');
			if($model->privateFolder === 'fa fa-lock'){
				$model->private_folder = 1;	
			}
			
			if($model->save()){
            	return ['output'=>$model->id, 'message'=>'sent','area'=>'folder','templateId'=>'0'];
			}
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Folder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
	
	public function actionUpdateFolderImage($id)
    {
		
        $model =  $this->findModel($id);
		

        if (Yii::$app->request->isPost) {
            $model->upload_file = UploadedFile::getInstance($model, 'upload_file');
            if ($model->upload()) {
                // file is uploaded successfully
				if($model->save()){
					return 1234;	
				} else{
					return 1233333;
				}
                
            }
        }

       // return $this->render('upload', ['model' => $model]);
    	
    
        }

    

    /**
     * Deletes an existing Folder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
		if(Yii::$app->request->isAjax) {
			$data = Yii::$app->request->post();   
			$id =  $data['folderId'];
			$userIdentityRole = yii::$app->user->identity->roleName;
			$userIdentityId = yii::$app->user->identity->id;
			$folderManager = FolderManager::find()->select('role')->andWhere(['folder_id'=>$id,'user_id' => $userIdentityId])->one();
			// use identity of the user to determine if the user has access to delete a folder or not 
			if($folderManager->role == 'author' or $userIdentityRole == 'admin' or $userIdentityRole == 'manager'){
				if(!empty($this->findModel($id)->delete())){
					return 0;
				}else{
					return 1;
				}
			}else{
				
				return 3;
			}
			
		}
		
		
    }
	
	/**
     * Deletes an existing Folder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $folderId, integer userId,
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
	public function actionDeleteUsers()
    {
		if(Yii::$app->request->isAjax) {
			$data = Yii::$app->request->post();   
			$folderId =  $data['folderId'];
			$userId =  $data['userId'];
			$userIdentityRole = yii::$app->user->identity->roleName;
			$userIdentityId = yii::$app->user->identity->id;
			$folderManager = FolderManager::find()->select('role')->andWhere(['folder_id'=>$folderId,'user_id' => $userIdentityId])->one();
			// use identity of the user to determine if the user has access to delete a folder or not 
			if($folderManager->role == 'author' or $userIdentityRole == 'admin' or $userIdentityRole == 'manager'){
				$folderManagerModel = new FolderManager();
				$findFolderUser = $folderManagerModel->find()->andWhere(['folder_id' => $folderId, 'user_id' => $userId])->one();
				if($findFolderUser->delete()){
					return 1;
				}else{
					return 0;
				}
			}else{
				return 3;
			}
			
		}
		
		
    }
	
	public function actionCheckIfFolderNameExist($folderName){
		$folder = new Folder();
		$checkIfItExist = $folder->find()->where(['title' => $folderName, 'cid' => yii::$app->user->identity->cid  ])->exists();
		if($checkIfItExist){
			return 1;
		}
	}

    /**
     * Finds the Folder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Folder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Folder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
		
	private function checkFolderParentRelationship(){
		$folderModel = Folder::findOne(34);
		return $folderModel -> subFolders;
	}
	


    public function actionMenusubfolders()
    {   
        $model = new Folder();
        if(isset($_GET['src'])){
            if(Yii::$app->request->post('page')){
                $id = Yii::$app->request->post('id');
                $getsubfolders = $model->findOne($id);
                $subfolders = $getsubfolders->subFolders;
                    
                return $this->renderAjax('menusubfolders', [
                        'subfolders' => $subfolders,
                ]);
            } 
        }
    }
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////// this set of methods would be used to solve a temp problem with que pending on when the issue is resolved 
	

	
	public function addFolderNewUser($userId = '', $folderId = '')
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
	
	
}
