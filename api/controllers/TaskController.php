<?php

namespace api\controllers;


use yii\filters\AccessControl;
use api\behaviours\Verbcheck;
use api\behaviours\Apiauth;
use frontend\models\Task;
use frontend\models\Folder;
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
    	$fetchTasks = $folderModel->clipOn['task'];
    	Yii::$app->api->sendSuccessResponse($fetchTasks);
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
            	Yii::$app->api->sendSuccessResponse($model->attributes);
			}else{
				Yii::$app->api->sendFailedResponse([$model->errors]);
			}
        }else{
        	Yii::$app->api->sendFailedResponse([$model->errors]);
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
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            Yii::$app->api->sendFailedResponse("Invalid Record requested");
        }
    }
}