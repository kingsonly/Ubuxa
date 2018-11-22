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
use frontend\models\Folder;
use frontend\models\TaskReminder;
use frontend\models\Label;
use frontend\models\TaskLabel;
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
        /** $model = new Task;
        $dataProvider = $model->displayTask();
        $task = StatusType::find()->where(['status_group' => 'task'])->all();
        $reminder = new Reminder();
            
        return $this->renderAjax('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'task' => $task,
            'reminder' => $reminder,
        ]); */
        $perpage=10;
        $task = new Task();
        if(isset($_GET['src1'])){
            if(Yii::$app->request->post('page')){
                $numpage = Yii::$app->request->post('page');
                $ownerid = Yii::$app->request->post('ownerId');
                $offset = (($numpage-1) * $perpage);
                     
                $taskclips = $task->specificClips($ownerid,2,$offset,$perpage,'task');
                return $this->renderAjax('index', [
                         'tasks' => $taskclips,
                     ]);
                
            } 
        }
    }

    public function actionIndex2()
    {   
        $perpage = 10;
        $task = new Task();

        if(isset($_GET['src'])){
            if(Yii::$app->request->post('page')){
                $numpage = Yii::$app->request->post('page');
                $ownerid = Yii::$app->request->post('ownerId');
                $modelName = Yii::$app->request->post('modelName');
                $DashboardUrlParam = Yii::$app->request->post('DashboardUrlParam');
                $offset = (($numpage-1) * $perpage);
                
                
                //if url is site index get all the remarks
                if($DashboardUrlParam == 'site'){
                     $tasks = Task::find()->limit($perpage)->offset($offset)->orderBy('id DESC')->all();
                    
                     return $this->renderAjax('sitetasks', [
                         'tasks' => $tasks,
                         'task' => $task,
                     ]);
                } else {
                     
                     $tasks = $task->specificClips($ownerid,1,$offset,$perpage,'task');
                     
                     return $this->renderAjax('index2', [
                         'tasks' => $tasks,
                         'task' => $task,
                     ]);
                }
                
            } 
        }
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id,$folderId)
    {
        $model = $this->findModel($id);
        $status = StatusType::find()->where(['status_group' => 'task'])->all();
        $folderModel = new Folder();
        $folder = $folderModel->findOne($folderId);
        $users = $folder->users;
        $label = new label();
        $taskLabel = new TaskLabel();
        $reminder = new Reminder();

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
            'users' => $users,
            'label' => $label,
            'taskLabel' => $taskLabel,
            'reminder' => $reminder,
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
        $model->create_date=new Expression('NOW()');
        $model->last_updated=new Expression('NOW()');
        $reminder = new Reminder();
        if ($model->load(Yii::$app->request->post())) {
            if(empty($model->due_date)){
                $model->due_date = NULL;
                $model->save();
            }elseif ($model->status_id == Task::TASK_IN_PROGRESS) {
                $model->in_progress_time = new Expression('NOW()');
                $model->save();
            }elseif ($model->status_id == Task::TASK_COMPLETED) {
                $model->completion_time = new Expression('NOW()');
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
        $model->status_id = Task::TASK_NOT_STARTED;
        $model->create_date=new Expression('NOW()');
        $model->last_updated=new Expression('NOW()');
        $reminder = new Reminder();
        if ($model->load(Yii::$app->request->post())) {
            if(empty($model->due_date)){
                $model->completion_time = NULL;
                $model->in_progress_time = NULL;
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
            $model->last_updated = new Expression('NOW()');
            if($statusid == Task::TASK_COMPLETED){
                $model->completion_time = new Expression('NOW()');
                $model->save();
            } elseif ($statusid == Task::TASK_IN_PROGRESS) {
                $model->in_progress_time = new Expression('NOW()');
                $model->save();
            }
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
            $taskModel = $this->findModel($task);
            $exists = TaskAssignedUser::find()->where(['task_id' => $task, 'user_id' => $user])->exists();
            $assignee = TaskAssignedUser::findOne(['task_id' => $task, 'user_id' => $user]);

            if($exists && $assignee->status == Task::TASK_ASSIGNED_STATUS) {
                $assignee->status = Task::TASK_NOT_ASSIGNED_STATUS;
                $taskModel->last_updated = new Expression('NOW()');
                $taskModel->save();
                $assignee->save();
            }else if($exists && $assignee->status == Task::TASK_NOT_ASSIGNED_STATUS){
                $assignee->status = Task::TASK_ASSIGNED_STATUS;
                $assignee->assigned_date = new Expression('NOW()');
                $taskModel->last_updated = new Expression('NOW()');
                $taskModel->save();
                $assignee->save();
            }else{
                $model->user_id = $user;
                $model->task_id = $task;
                $model->status = Task::TASK_ASSIGNED_STATUS;
                $model->assigned_date = new Expression('NOW()');
                $taskModel->last_updated = new Expression('NOW()');
                $taskModel->save();
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
    /** public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    } */

    public function actionDelete()
    {
        if(Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();   
            $id =  $data['task_id'];
            $model = $this->findModel($id)->delete();
        }
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
