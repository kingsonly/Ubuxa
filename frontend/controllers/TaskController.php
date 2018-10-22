<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Task;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\StatusType;
use yii\db\Expression;
use frontend\models\Reminder;
use frontend\models\TaskReminder;
use frontend\models\TaskAssignedUser;



/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
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
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Task;
        $dataProvider = $model->displayTask();
        $task = StatusType::find()->where(['status_group' => 'task'])->all();
        $reminder = new Reminder();
            
        return $this->renderAjax('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'task' => $task,
            'reminder' => $reminder,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $status = StatusType::find()->where(['status_group' => 'task'])->all();

        // Check if there is an Editable ajax request
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

        return $this->renderAjax('view', [
            'model' => $model,
            'status' => $status,
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();
        $model->owner = Yii::$app->user->identity->id;
        //$model->status_id = 21;
        $model->create_date=new Expression('NOW()');
        $model->last_updated=new Expression('NOW()');
        $reminder = new Reminder();
        if ($model->load(Yii::$app->request->post())) {
            if(empty($model->due_date)){
                $model->due_date = NULL;
                $model->save();
            }else{
                $model->save();
            }
            
            $model = new Task();
        }

        return $this->renderAjax('create', [
            'reminder' => $reminder,
            'model' => $model,
        ]);
    }

    public function actionDashboardcreate()
    {
        $model = new Task();
        $model->owner = Yii::$app->user->identity->id;
        $model->status_id = 21;
        $model->create_date=new Expression('NOW()');
        $model->last_updated=new Expression('NOW()');
        $reminder = new Reminder();
        if ($model->load(Yii::$app->request->post())) {
            if(empty($model->due_date)){
                $model->due_date = NULL;
                $model->save();
            }else{
                $model->save();
            }
            
            $model = new Task();
        }

        return $this->renderAjax('dashboardcreate', [
            'reminder' => $reminder,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['site']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionKanban()
    {
        
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();   
            $id =  $data['id'];
            $model = $this->findModel($id);
            $statusid = $data['status_id'];
            $model->status_id = $statusid;
            $model->save();
        }
    }

    public function actionAssignee()
    {    
        $model = new TaskAssignedUser();
        
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();   
            $user =  $data['user_id'];
            $task =  $data['task_id'];
            $exists = TaskAssignedUser::find()->where(['task_id' => $task, 'user_id' => $user])->exists();
            $assignee = TaskAssignedUser::findOne(['task_id' => $task, 'user_id' => $user]);

            if($exists && $assignee->status == 1) {
                $assignee->status = 0;
                $assignee->save();
            }else if($exists && $assignee->status == 0){
                $assignee->status = 1;
                $assignee->assigned_date = new Expression('NOW()');
                $assignee->save();
            }else{
                $model->user_id = $user;
                $model->task_id = $task;
                $model->status = 1;
                $model->assigned_date = new Expression('NOW()');
                $model->save();
            }

        }
    }

    /**
     * Deletes an existing Task model.
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

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
