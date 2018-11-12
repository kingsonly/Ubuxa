<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Folder;
use frontend\models\Person;
use frontend\models\InviteUsers;
use frontend\models\Task;
use frontend\models\Remark;
use frontend\models\StatusType;
use frontend\models\Reminder;
use frontend\models\Label;
use frontend\models\TaskLabel;
use frontend\models\TaskAssignedUser;
use frontend\models\UserDb;
use frontend\models\Component;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\UploadedFile;
use boffins_vendor\queue\FolderUsersQueue;

/**
 * FolderController implements the CRUD actions for Folder model.
 */
class FolderController extends Controller
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
		
        return $this->render('index', [
            'folders' => $seperateFolders,
        ]);
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
        $componentModel = new Component();
        $taskLabel = new TaskLabel();
        $taskAssignedUser = new TaskAssignedUser();
        $cid = Yii::$app->user->identity->cid;
        $users = $model->users;
		$componentCreateUrl = Url::to(['component/create']);
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
			'remarkModel' => $remark,
		    'taskStatus' => $taskStatus,
            'reminder' => $reminder,
            'label' => $label,
            'taskLabel' => $taskLabel,
            'taskAssignedUser' => $taskAssignedUser,
            'users' => $users,
            'id' => $id,
            'componentCreateUrl' => $componentCreateUrl,
            'componentModel' => $componentModel,
        ]);
    }
	
	public function actionUsers($q = null, $id = null) {
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$out = ['results' => ['id' => '', 'text' => '']];
		if (!is_null($q)) {
			$query = new Person();
			$allUsers = $query->find()->select('id, first_name, surname')
				->where(['like', 'first_name', $q])->orWhere(['like', 'surname', $q])->all();
			
			$out['results'] = array_values($allUsers);
		}
		elseif ($id > 0) {
			$out['results'] = ['id' => 0, 'first_name' => 'could not find ','surname' => 'a any user'];
		}
		return $out;
	}
	
	public function actionAddUsers($id) {
		$inviteUsersModel = new InviteUsers();
		$userModel = new UserDb();
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		 if ($inviteUsersModel->load(Yii::$app->request->post())) {
			  $test = 0;
			 foreach($inviteUsersModel->users as $value){
				 $getUserId = $userModel->find()->select(['id'])->where(['person_id' => $value])->one();
				 $test = $getUserId['id'];
				 Yii::$app->queue->push(new FolderUsersQueue([
					'userId' => $getUserId['id'],
					'folderId' => $id,
				]));
			 }
            return ['output'=>$id, 'message'=> $test];
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
            	return ['output'=>$model->id, 'message'=>'sent'];
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
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
	
	private function reQueueEachChildFolder(){
		//$this->addNewUser(24, 34);
		
		if(!empty($this->checkFolderParentRelationship())){
			
			
			//foreach($this->checkFolderParentRelationship() as $folderId){
				
				$queue = new Queue();
				 $queue->push(new FolderUsersQueue([
					'userId' => 24,
					'folderId' => 34,
				]));
			//$this->addNewUser(24, 34);
				
			//}
		} 
	}
}
