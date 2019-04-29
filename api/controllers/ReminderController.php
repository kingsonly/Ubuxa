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
        Yii::$app->api->sendSuccessResponse($reminders);
    }


   public function actionCreate($taskId)
   {
        $model = new Reminder();
        $presentTime = new Expression('NOW()');
        $taskReminder = new TaskReminder();
        $model->attributes = $this->request;
        $taskReminder->attributes = $this->request;
        $model->last_updated = $presentTime;

        if(!empty($model)){
            if ($model->save()) {
                $taskReminder->reminder_id = $model->id;
                $taskReminder->task_id = $taskId;
                $taskReminder->save(false);
               Yii::$app->api->sendSuccessResponse($model->attributes);
            }else{
                Yii::$app->api->sendFailedResponse($model->attributes);
            }
        }else{
            Yii::$app->api->sendFailedResponse($model->attributes);
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
				Yii::$app->api->sendFailedResponse($model->attributes);
			}
		}
	}

	public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->api->sendSuccessResponse($model->attributes);
    }

    protected function findModel($id)
    {
        if (($model = Reminder::findOne($id)) !== null) {
            return $model;
        } else {
            Yii::$app->api->sendFailedResponse("Invalid Record requested");
        }
    }
}