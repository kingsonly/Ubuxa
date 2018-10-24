<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Folder;
use frontend\models\Task;
use frontend\models\Remark;
use frontend\models\StatusType;
use frontend\models\Reminder;
use frontend\models\TaskAssignedUser;
use frontend\models\UserDb;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\web\UploadedFile;

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
        $folderModel = new Folder();
       $dataProvider = $folderModel->find()->all();
		
        return $this->render('index', [
            'dataProvider' => $dataProvider,
           
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
		
		$model = $this->findModel($id);
        $task = new Task();
		$remark = new Remark();
        $taskStatus = StatusType::find()->where(['status_group' => 'task'])->all();
        $reminder = new Reminder();
        $taskAssignedUser = new TaskAssignedUser();
        $cid = Yii::$app->user->identity->cid;
        $users = UserDb::find()->where(['cid' => $cid])->all();
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
            'taskAssignedUser' => $taskAssignedUser,
            'users' => $users,
            'id' => $id,
        ]);
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
				//return $this->redirect(['view', 'id' => $model->id]);
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
}
