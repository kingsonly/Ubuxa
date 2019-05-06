<?php

namespace api\controllers;


use yii\filters\AccessControl;
use api\behaviours\Verbcheck;
use api\behaviours\Apiauth;
use frontend\models\Edocument;
use frontend\models\Folder;
use frontend\models\Task;
use Yii;
use yii\db\Expression;



class EdocumentController extends RestController
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

    public function actionFolderDocuments($folderId)
    {
        $folderModel = Folder::findOne($folderId);
        if(empty($folderModel)){
            Yii::$app->api->sendFailedResponse('Folder does not exist');
        }else{
            if(empty($folderModel->clipOn['edocument'])){
                Yii::$app->api->sendFailedResponse('There are no edocument in this folder');
            }else{
                $folderEdocs = $folderModel->clipOn['edocument'];
                Yii::$app->api->sendSuccessResponse($folderEdocs);
            }
        }
    }

    public function actionTaskDocuments($taskId)
    {
        $taskModel = Task::findOne($taskId);
        if(empty($taskModel)){
            Yii::$app->api->sendFailedResponse('Task does not exist');
        }else{
            if(empty($taskModel->clipOn['edocument'])){
                Yii::$app->api->sendFailedResponse('There are no edocument for this task');
            }else{
                $taskEdocs = $taskModel->clipOn['edocument'];
                Yii::$app->api->sendSuccessResponse($taskEdocs);
            }
        }
    }

    public function actionUpload($reference, $referenceID)
    {
        $model = new Edocument();
        $fileName = 'file';
        $cid = Yii::$app->user->identity->cid;
        $uploadPath = 'images/';
        $cidPath = 'edocuments/'.$cid; //set path with customer id
        $userId = Yii::$app->user->identity->id; //get user id
        $model->attributes = $this->request;
        if (isset($_FILES[$fileName])) {
            if($model->documentUpload($fileName, $cid, $uploadPath, $cidPath, $userId, $reference, $referenceID)){
                Yii::$app->api->sendSuccessResponse($model->attributes); 
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
                unlink($model->file_location); //delete file from folder path
				Yii::$app->api->sendSuccessResponse($model->attributes);
			}else{
				if (!$model->validate()) {
					Yii::$app->api->sendFailedResponse($model->errors);
				}
			}
		}
    }

    protected function findModel($id)
    {
        if (($model = Edocument::findOne($id)) !== null) {
            return $model;
        } else {
            Yii::$app->api->sendFailedResponse("Invalid Record requested");
        }
    }
}