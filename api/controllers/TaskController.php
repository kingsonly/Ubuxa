<?php

namespace api\controllers;


use yii\filters\AccessControl;
use api\behaviours\Verbcheck;
use api\behaviours\Apiauth;
use frontend\models\Task;
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


   public function actionCreate()
   {
        $model = new Task();
		$model->attributes = $this->request;
        if (!empty($model->attributes['title'])) {
			$model->last_updated =  new Expression('NOW()');
			$model->completion_time = NULL;
            $model->in_progress_time = NULL;
            $model->due_date = NULL;
			if($model->save()){
            	Yii::$app->api->sendSuccessResponse($model->attributes);
			}
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
				Yii::$app->api->sendFailedResponse(['Could not update']);
			}
		}
	}

    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            Yii::$app->api->sendFailedResponse("Invalid Record requested");
        }
    }
}