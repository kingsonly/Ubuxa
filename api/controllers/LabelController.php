<?php

namespace api\controllers;


use yii\filters\AccessControl;
use api\behaviours\Verbcheck;
use api\behaviours\Apiauth;
use frontend\models\Label;
use frontend\models\Task;
use frontend\models\TaskLabel;
use Yii;
use yii\db\Expression;



class LabelController extends RestController
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
        $labels = $taskModel->labels;
		if(!empty($labels)){
			 return Yii::$app->apis->sendSuccessResponse($reminders);
		}
    }


   public function actionCreate($taskId)
   {
        $model = new Label();
        $taskLabel = new TaskLabel();
        $model->attributes = $this->request;

        if (!empty($model->attributes)) {
            if($model->save()){
                $taskLabel->label_id = $model->id;
                $taskLabel->task_id = $taskId;
                $taskLabel->save();
                return Yii::$app->apis->sendSuccessResponse($model->attributes);
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
		if(!empty($model->attributes)){
			if ($model->save()) {
			   return Yii::$app->apis->sendSuccessResponse($model->attributes);
			}else{
				if (!$model->validate()) {
					return Yii::$app->apis->sendFailedResponse($model->errors);
				}
			}
		}else{
			if (!$model->validate()) {
				return Yii::$app->apis->sendFailedResponse($model->errors);
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
		}
        
    }

    protected function findModel($id)
    {
        if (($model = Label::findOne($id)) !== null) {
            return $model;
        } else {
            return Yii::$app->apis->sendFailedResponse("Invalid Record requested");
        }
    }
}