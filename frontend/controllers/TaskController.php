<?php
/**
 * @copyright Copyright (c) 2019 Epsolun Limited
*/
namespace frontend\controllers;

use Yii;
use frontend\models\Task;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\StatusType;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use frontend\models\Reminder;
use frontend\models\Folder;
use frontend\models\TaskReminder;
use frontend\models\Label;
use frontend\models\TaskLabel;
use frontend\models\TaskAssignedUser;
use frontend\models\TaskGroup;
use frontend\models\TaskColor;
use frontend\models\Edocument;
use frontend\models\UserDb;
use boffins_vendor\classes\BoffinsBaseController;

/**
 * TaskController implements the CRUD actions for Task model.
 * @author Jeff Reifman
 * @since v1.0
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
   /* public function actionIndex($folderIds)
    {
        $taskStatus = StatusType::find()->where(['status_group' => 'task'])->all();
        $reminder = new Reminder();
        $label = new label();
        $taskLabel = new TaskLabel();
        $taskAssignedUser = new TaskAssignedUser();
        $cid = Yii::$app->user->identity->cid;
        $userId = Yii::$app->user->identity->id;
        $folder = Folder::findOne($folderIds);
        $users = $folder->users;
        $dataProvider = $folder->clipOn['task'];
        $perpage=10;
        $task = new Task();
        $task->fromWhere = 'folder';
        if(isset($_GET['src'])){
            if(Yii::$app->request->post('page')){
                $numpage = Yii::$app->request->post('page');
                $ownerid = Yii::$app->request->post('ownerId');
                $modelName = Yii::$app->request->post('modelName');
                $DashboardUrlParam = Yii::$app->request->post('DashboardUrlParam');
                $offset = (($numpage-1) * $perpage);
                     
                $taskclips = $task->specificClips($ownerid,2,$offset,$perpage,'task');
                return $this->renderAjax('index', [
                    'task' => $task,
                    'taskclips' => $taskclips,
                    'taskStatus' => $taskStatus,
                    'reminder' => $reminder,
                    'label' => $label,
                    'taskLabel' => $taskLabel,
                    'taskAssignedUser' => $taskAssignedUser,
                    'users' => $users,
                    'userId' => $userId,
                    'dataProvider' => $dataProvider,
                    'folderIds' => $folderIds,
                ]);
                
            } 
        }
    }*/

    /**
     * Render an Ajax task list with infinite scroll
     *
     * @param integer $folderId 
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionIndex($folderId)
    {   
        $perpage = 10;
        $task = new Task();
        $task->fromWhere = 'folder';
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
                     $tasks = $task->specificClips($ownerid,2,$offset,$perpage,'task');
                     return $this->renderAjax('index2', [
                         'tasks' => $tasks,
                         'task' => $task,
                         'folderId' => $folderId,
                     ]);
                }
                
            } 
        }
    }


    /**
     * Render an Ajax task modal 
     *
     * @param integer $folderId 
     * @return mixed
     * @throws NotFoundHttpException if the @param cannot be found
     */

    public function actionModal($id,$folderId)
    {

        return $this->renderAjax('modal', [
            'id' => $id,
            'folderId' => $folderId,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id, $folderId
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
        $edocument = $model->clipOn['edocument'];
        $assigneesIds = $model->taskAssigneesUserId;
        $userid = Yii::$app->user->identity->id;
        $statusData = ArrayHelper::map(StatusType::find()->where(['status_group' => 'task'])->all(), 'id', 'status_title');

        // Check if there is an Editable ajax request
        if (isset($_POST['hasEditable'])) 
        {
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
            'edocument' => $edocument,
            'folderId' => $folderId,
            'assigneesIds' => $assigneesIds,
            'userid' => $userid,
            'statusData' => $statusData,
        ]);
    }

    /**
     * Creates a new Task model.
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

    /**
     * Creates a new Task model.
     * @return mixed
     */
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
                if(!empty(Yii::$app->request->post('field'))){
                
                    $model->title = Yii::$app->request->post('field');
                    $model->completion_time = NULL;
                    $model->in_progress_time = NULL;
                    $model->due_date = NULL;
                    $model->status_id = 1;
                    
                    if($model->save()){
                        $taskGroupModel = new TaskGroup();
                        $taskGroupModel->task_group_id = $model->id;
                        $taskGroupModel->task_child_id = $model->id;
                        $taskGroupModel->save();
                        return $model->id;
                        
                    }
                } elseif(!empty(Yii::$app->request->post('taskgroupid'))){
                    $model->completion_time = NULL;
                    $model->in_progress_time = date('Y-m-d H:i:s');
                    $model->due_date = NULL;
                    $model->status_id = 1;
                    
                    if($model->save()){
                        $taskGroupModel = new TaskGroup();
                        $taskGroupModel->task_group_id = Yii::$app->request->post('taskgroupid');
                        $taskGroupModel->task_child_id = $model->id;
                        $taskGroupModel->save();
                        return json_encode([$model->id,$model->title,$model->in_progress_time]);
                        
                    }

                } else {
                    $model->completion_time = NULL;
                    $model->in_progress_time = NULL;
                    $model->due_date = NULL;
                    if($model->save()){
                        $taskGroupModel = new TaskGroup();
                        $taskGroupModel->task_group_id = $model->id;
                        $taskGroupModel->task_child_id = $model->id;
                        $taskGroupModel->save();
                        return json_encode($model->attributes);
                    }
                }
                
            }else{
                if($model->save()){
                    $taskGroupModel = new TaskGroup();
                    $taskGroupModel->task_group_id = $model->id;
                    $taskGroupModel->task_child_id = $model->id;
                    $taskGroupModel->save();
                }
            }
            
            
        }
            return 4;
        return $this->renderAjax('dashboardcreate', [
            'reminder' => $reminder,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return $model
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

    /**
     * Update the task status when task board is dragged
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
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
                return json_encode($id);
            } elseif ($statusid == Task::TASK_IN_PROGRESS) {
                $model->in_progress_time = new Expression('NOW()');
                $model->save();
            }
            $model->save();
        }
    }

    /**
     * Render an Ajax task board
     *
     * @param integer $folderIds 
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionBoard($folderIds)
    {   
        $task = new Task();
        $taskStatus = StatusType::find()->where(['status_group' => 'task'])->all();
        $reminder = new Reminder();
        $label = new label();
        $taskLabel = new TaskLabel();
        $taskAssignedUser = new TaskAssignedUser();
        $cid = Yii::$app->user->identity->cid;
        $userId = Yii::$app->user->identity->id;
        $folder = Folder::findOne($folderIds);
        $users = $folder->users;
        $dataProvider = $folder->clipOn['task'];
        
        return $this->renderAjax('board', [
            'task' => $task,
            'taskModel' => $task,
            'taskStatus' => $taskStatus,
            'reminder' => $reminder,
            'label' => $label,
            'taskLabel' => $taskLabel,
            'taskAssignedUser' => $taskAssignedUser,
            'users' => $users,
            'userId' => $userId,
            'folderIds' => $folderIds,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Add or removes assignees from a task
     *
     * @return method
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionAssignee()
    {    
        $model = new TaskAssignedUser();
        $userDb = new UserDb();
        
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
                $assignee->save();
                $taskModel->save();
                return $model->taskAssignee($user, $userDb, $task, $assignee->status);
            }else if($exists && $assignee->status == Task::TASK_NOT_ASSIGNED_STATUS){
                $assignee->status = Task::TASK_ASSIGNED_STATUS;
                $assignee->assigned_date = new Expression('NOW()');
                $taskModel->last_updated = new Expression('NOW()');
                $taskModel->save();
                $assignee->save();
                Yii::warning("Saving it 2?", "Subscription ke");
                return $model->taskAssignee($user, $userDb, $task, $assignee->status);
            }else{
                $model->user_id = $user;
                $model->task_id = $task;
                $model->status = Task::TASK_ASSIGNED_STATUS;
                $model->assigned_date = new Expression('NOW()');
                $taskModel->last_updated = new Expression('NOW()');
                $taskModel->save();
                $model->save();
                Yii::warning("Saving it?", "Subscription ke");
                return $model->taskAssignee($user, $userDb, $task, $model->status);
            }

        }
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionDelete()
    {
        if(Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();   
            $id =  $data['task_id'];
            $model = $this->findModel($id)->delete();
        }
    }

    /**
     * Deletes an existing Calendar Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionCalendartaskdelete()
    {   

        if(Yii::$app->request->post('id')) {
            $taskId = Yii::$app->request->post('id');
            $deleteTask = Task::findOne($taskId);
            $deleteTask->delete();
        }
    }

    /**
     * Updates an existing Task model.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdatetask()
    {   
      if(Yii::$app->request->post('id')) {
            $taskId = Yii::$app->request->post('id');
            $updateTask = Task::findOne($taskId);
            return json_encode([$updateTask->title, $updateTask->in_progress_time]);
        }  
    }

    /**
     * Updates an existing Calendar Task model.
     * @param $id
     * @return 1 or 0
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCalendartaskupdate($id)
    {
      $updateTask = Task::findOne($id);
      $postVariable = Yii::$app->request->post();
      $Datetime = $postVariable["Task"]["in_progress_time"].':00';
      $updateTask->in_progress_time = $Datetime;
      if($updateTask->load(Yii::$app->request->post()) && $updateTask->save()) {
          return 1;
        } else {
            return 0;
        }
    }


    /**
     * Updates an existing Task model.
     * @details This action updates the task list when a task is checked.
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionCheckTask()
    {
        $task = new Task();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();   
            $checkedId =  $data['id'];

            $model = Task::findOne($checkedId);

            if($model->status_id != $task::TASK_COMPLETED){
                $model->status_id = $task::TASK_COMPLETED;
                $model->save();
            } else {
                $model->status_id = $task::TASK_NOT_STARTED;
                $model->save();
            }
            
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
