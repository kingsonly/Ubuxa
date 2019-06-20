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
           return Yii::$app->apis->sendFailedResponse('Folder does not exist');
        }else{
            if(empty($folderModel->clipOn['edocument'])){
                return Yii::$app->apis->sendFailedResponse('There are no edocument in this folder');
            }else{
                $folderEdocs = $folderModel->clipOn['edocument'];
                foreach ($folderEdocs as $key => $docs) {
                    $edocuments[$key] =  $docs->attributes;
                    $edocuments[$key]['basename'] = basename($docs->file_location);
                    $edocuments[$key]['extension'] = pathinfo($docs->file_location, PATHINFO_EXTENSION);   
                    $edocuments[$key]['time_elapsed'] = $docs->timeElapsedString; 
                    $edocuments[$key]['owner'] = $docs->username; 
                }
                $documents[] = $edocuments;
                $response = $documents;
                
                return Yii::$app->apis->sendSuccessResponse([$response]);
            }
        }
    }

    public function actionTaskDocuments($taskId)
    {
        $taskModel = Task::findOne($taskId);
        if(empty($taskModel)){
            return Yii::$app->apis->sendFailedResponse('Task does not exist');
        }else{
            if(empty($taskModel->clipOn['edocument'])){
               return Yii::$app->apis->sendFailedResponse('There are no edocument for this task');
            }else{
                $taskEdocs = $taskModel->clipOn['edocument'];
                foreach ($taskEdocs as $key => $docs) {
                    $edocuments[$key] =  $docs->attributes;
                    $edocuments[$key]['basename'] = basename($docs->file_location);
                    $edocuments[$key]['extension'] = pathinfo($docs->file_location, PATHINFO_EXTENSION);   
                    $edocuments[$key]['time_elapsed'] = $docs->timeElapsedString; 
                    $edocuments[$key]['owner'] = $docs->username; 
                }
                $documents[] = $edocuments;
                $response = $documents;
                return Yii::$app->apis->sendSuccessResponse([$response]);
            }
        }
    }

    public function actionUpload($reference, $referenceID)
    {
        $model = new Edocument();
		$model->controlerLocation = 'API';
        $fileName = 'file';
        $cid = Yii::$app->user->identity->cid;
        $uploadPath = 'images/';
        $cidPath = 'edocuments/'.$cid; //set path with customer id
        $userId = Yii::$app->user->identity->id; //get user id
        $model->attributes = $this->request;
        if (isset($_FILES[$fileName])) {
            if($model->documentUpload($fileName, $cid, $uploadPath, $cidPath, $userId, $reference, $referenceID)){
                $models['id'] =  $model->attributes;
                $models['id']['basename'] = basename($model->file_location);
                $models['id']['extension'] = pathinfo($model->file_location, PATHINFO_EXTENSION);   
                $models['id']['time_elapsed'] = $model->timeElapsedString; 
                $models['id']['owner'] = $model->username; 
                return Yii::$app->apis->sendSuccessResponse($models); 
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
                unlink($model->file_location); //delete file from folder path
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
        if (($model = Edocument::findOne($id)) !== null) {
            return $model;
        } else {
            return Yii::$app->apis->sendFailedResponse("Invalid Record requested");
        }
    }
}