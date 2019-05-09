<?php

namespace api\controllers;


use yii\filters\AccessControl;
use api\behaviours\Verbcheck;
use api\behaviours\Apiauth;
use frontend\models\Reminder;
use frontend\models\Task;
use frontend\models\TaskReminder;
use Yii;
use yii\db\Expression;



class ReminderController extends RestController
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

    public function actionIndex($taskId)
    {
        $taskModel = Task::findOne($taskId);
        $reminders = $taskModel->reminderTimeTask;
		if(empty($reminders)){
			 Yii::$app->api->sendFailedResponse('Task does not have a reminder');
		}else{
			return Yii::$app->apis->sendSuccessResponse($reminders);
		}
        
    }


   public function actionCreate($taskId)
   {
        $model = new Reminder();
        $presentTime = new Expression('NOW()');
        $taskReminder = new TaskReminder();
        $model->attributes = $this->request;
        $taskReminder->attributes = $this->request;
        $model->last_updated = $presentTime;

        if(!empty($model->attributes)){
            if ($model->save()) {
                $taskReminder->reminder_id = $model->id;
                $taskReminder->task_id = $taskId;
                $taskReminder->save(false);
               return Yii::$app->apis->sendSuccessResponse($model->attributes);
            }else{
               // Yii::$app->api->sendFailedResponse($model->attributes);
				if (!$model->validate()) {
					Yii::$app->api->sendFailedResponse($model->errors);
				}
            }
        }else{
			if (!$model->validate()) {
				Yii::$app->api->sendFailedResponse($model->errors);
			}
            //Yii::$app->api->sendFailedResponse($model->attributes);
        }
   	}


    public function actionUpdate($id)
    {
		
        $model =  $this->findModel($id);
		$model->attributes = $this->request;
		if(!empty($model->attributes)){
			if ($model->save()) {
			   return Yii::$app->apis->sendSuccessResponse($model->attributes);
			}else{
				if (!$model->validate()) {
					Yii::$app->api->sendFailedResponse($model->errors);
				}
			}
		}else{
			if (!$model->validate()) {
				Yii::$app->api->sendFailedResponse($model->errors);
			}
		}
	}

	public function actionDelete($id)
    {
        $model = $this->findModel($id);
		if(!empty($model)){
			if($model->delete()){
				return Yii::$app->apis->sendSuccessResponse($model->attributes);
			}else{
				if (!$model->validate()) {
					return Yii::$app->apis->sendFailedResponse($model->errors);
				}
			}
		}else{
			return Yii::$app->apis->sendFailedResponse('Reminder is empty or does not exist');
		}
        
        
    }

    protected function findModel($id)
    {
        if (($model = Reminder::findOne($id)) !== null) {
            return $model;
        } else {
            return Yii::$app->apis->sendFailedResponse("Invalid Record requested");
        }
    }
}