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
use linslin\yii2\curl;
use yii\helpers\Json;



/**
 * FolderController implements the CRUD actions for Folder model.
 */
class FoldersegmentedviewController extends BoffinsBaseController
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
        $onboardingModel = Onboarding::find()->where(['user_id' => $userId]);
        $onboardingExists = $onboardingModel->exists(); 
        $onboarding = $onboardingModel->one();
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
	
	
   

    /**
     * Deletes an existing Folder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
	
	public function actionToprow($id){
		$model = $this->findModel($id);
		$img = $model->folder_image;
		$userId = $this->userId();
		$onboardingModel = Onboarding::find()->where(['user_id' => $userId]);
        $onboardingExists = $onboardingModel->exists(); 
        $onboarding = $onboardingModel->one();
		
		
		
		return $this->renderAjax('toprow', [
            'model' => $model,
            'img' => $img,
            'onboardingExists' => $onboardingExists,
            'onboarding' => $onboarding,
            'userId' => $userId,
            
        ]);
	}
	
	private function accountCid(){
		return Yii::$app->user->identity->cid;
	}
	
	private function userId(){
		return Yii::$app->user->identity->id;
	}
  
    protected function findModel($id)
    {
        if (($model = Folder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
		
	
}
