<?php

namespace api\controllers;


use yii\filters\AccessControl;
use api\behaviours\Verbcheck;
use api\behaviours\Apiauth;
use frontend\models\Task;
use frontend\models\UserDb;
use frontend\models\Folder;
use frontend\models\TaskAssignedUser;
use Yii;
use yii\db\Expression;



class TaskController extends RestController
{
 
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [

           'apiauth' => [
               'class' => Apiauth::className(),
               'exclude' => [],
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
	
	public function actionIndex($folderId)
	{
    	$folderModel = Folder::findOne($folderId);
		if(empty($folderModel)){
			return Yii::$app->apis->sendFailedResponse('Folder  does not exist');
		}else{
			if(empty($folderModel->clipOn['task'])){
				return Yii::$app->apis->sendFailedResponse('There are no task in this folder');
			}else{
				$fetchTasks = $folderModel->clipOn['task'];
                /*foreach ($fetchTasks as $value) {
                    $tasks[$value->status_id][] = $value;
                }*/
    			return Yii::$app->apis->sendSuccessResponse($fetchTasks);
			}
		}
	}

	public function actionCreate()
	{
		$model = new Task();
		$model->attributes = $this->request;
        if (!empty($model->attributes['title'])) {
			$model->last_updated =  new Expression('NOW()');
			$model->create_date =  new Expression('NOW()');
			$model->completion_time = NULL;
            $model->in_progress_time = NULL;
            $model->due_date = NULL;
            $model->status_id = Task::TASK_NOT_STARTED;
            $model->owner = Yii::$app->user->identity->id;
            $model->fromWhere = 'folder';
			if($model->save()){
            	return Yii::$app->apis->sendSuccessResponse($model->attributes);
			}else{
				if (!$model->validate()){
					return Yii::$app->apis->sendFailedResponse($model->errors);
				}
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
        $userid = Yii::$app->user->identity->id;
        $assigneesIds = $model->taskAssigneesUserId;
		if(!empty($model)){
            if($userid == $model->owner || in_array($userid, $assigneesIds)){
        		if ($model->save()) {
        		   return Yii::$app->apis->sendSuccessResponse($model->attributes);
        		}else{
        			if (!$model->validate()) {
        				return Yii::$app->apis->sendFailedResponse($model->errors);
        			}
        		}
            }else{
                return Yii::$app->apis->sendFailedResponse("You don't have permission to edit this task");
            }
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

    public function actionView($id)
    {
        $model = $this->findModel($id);
        if(empty($model)){
            return Yii::$app->apis->sendFailedResponse('task does not exist');
        }else{
            $response = $model->attributes;
            array_walk_recursive($response,function(&$item){$item=strval($item);});
            return Yii::$app->apis->sendSuccessResponse($response);
        }
        
    }

    public function actionAssignee($user, $task)
    {    
        $model = new TaskAssignedUser();
        $userDb = new UserDb();
        $model->attributes = $this->request;
        if (!empty($model)) {
            $taskModel = $this->findModel($task);
            $exists = TaskAssignedUser::find()->where(['task_id' => $task, 'user_id' => $user])->exists();
            $assignee = TaskAssignedUser::findOne(['task_id' => $task, 'user_id' => $user]);

            if($exists && $assignee->status == Task::TASK_ASSIGNED_STATUS) {
                $assignee->status = Task::TASK_NOT_ASSIGNED_STATUS;
                $taskModel->last_updated = new Expression('NOW()');
                $assignee->save();
                $taskModel->save();
                return Yii::$app->apis->sendSuccessResponse($model->taskApiAssignees($user, $userDb, $task, $assignee->status));
            }else if($exists && $assignee->status == Task::TASK_NOT_ASSIGNED_STATUS){
                $assignee->status = Task::TASK_ASSIGNED_STATUS;
                $assignee->assigned_date = new Expression('NOW()');
                $taskModel->last_updated = new Expression('NOW()');
                $taskModel->save();
                $assignee->save();
                return Yii::$app->apis->sendSuccessResponse($model->taskApiAssignees($user, $userDb, $task, $assignee->status));
            }else{
                $model->user_id = $user;
                $model->task_id = $task;
                $model->status = Task::TASK_ASSIGNED_STATUS;
                $model->assigned_date = new Expression('NOW()');
                $taskModel->last_updated = new Expression('NOW()');
                $taskModel->save();
                $model->save();
                return Yii::$app->apis->sendSuccessResponse($model->taskApiAssignees($user, $userDb, $task, $model->status));
            }
        }else{
           if (!$model->validate()) {
                    return Yii::$app->apis->sendFailedResponse($model->errors);
            } 
        }
    }

    public function actionCheckTask($id)
    {
        $model = new Task();
        $model->attributes = $this->request;
        if (!empty($model)) {
            
            $model = Task::findOne($id);

            if($model->status_id != $model::TASK_COMPLETED){
                $model->status_id = $model::TASK_COMPLETED;
                $model->save();
                return Yii::$app->apis->sendSuccessResponse($model->attributes);
            } else {
                $model->status_id = $model::TASK_NOT_STARTED;
                $model->save();
                return Yii::$app->apis->sendSuccessResponse($model->attributes);
            }
            
        }else{
           return Yii::$app->apis->sendFailedResponse($model->errors); 
        }
    }

    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            return Yii::$app->apis->sendFailedResponse("Invalid Record requested");
        }
    }
}