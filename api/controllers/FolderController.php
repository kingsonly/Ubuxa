<?php

namespace api\controllers;


use yii\filters\AccessControl;
use api\behaviours\Verbcheck;
use api\behaviours\Apiauth;
use frontend\models\Folder;

use Yii;



class FolderController extends RestController
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

    public function actionIndex()
    {
        $folder = Folder::find()->all();
		$seperateFolders = array();
		foreach ($folder as $firstFolderFilter) {
			if($firstFolderFilter->private_folder == $firstFolderFilter::DEFAULT_PRIVATE_FOLDER_STATUS){
				$folderStatus = 'public';
			}else{
				$folderStatus = 'private';
			}
			if($firstFolderFilter->parent_id > $firstFolderFilter::DEFAULT_FOLDER_PARENT_STATUS){
				$CheckParentfolderAccess = Folder::findOne(['id' => $firstFolderFilter->parent_id ]); 
			}
			if($firstFolderFilter->parent_id == $firstFolderFilter::DEFAULT_FOLDER_PARENT_STATUS ){
				if($firstFolderFilter->folderManagerFilter->role == 'author'){
					$seperateFolders['root folder'][$folderStatus][] = $firstFolderFilter;
				}else{
					$seperateFolders['root folder']['shared'][] = $firstFolderFilter;
				}
			} else{
				if($firstFolderFilter->folderManagerFilter->role == 'author'){
					$news = ['test' => $firstFolderFilter->folderManagerFilter->role];
					$myArray['folderDetails'] =  [$firstFolderFilter];
					$myArray['folderDetails']['otherdetails']=$news; 
					
					$seperateFolders['sub folder'][$folderStatus][] = $myArray;
					
				}else{
					$seperateFolders['sub folder']['shared'][] = $firstFolderFilter;
				}
			}
			

		}
		
        $response = $seperateFolders;
        Yii::$app->api->sendSuccessResponse($response);
		
    }

    public function actionCreate()
    {

        $model = new Employee;
        $model->attributes = $this->request;

        if ($model->save()) {
            Yii::$app->api->sendSuccessResponse($model->attributes);
        } else {
            Yii::$app->api->sendFailedResponse($model->errors);
        }

    }

    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $model->attributes = $this->request;

        if ($model->save()) {
            Yii::$app->api->sendSuccessResponse($model->attributes);
        } else {
            Yii::$app->api->sendFailedResponse($model->errors);
        }

    }

    public function actionView($id)
    {

        $model = $this->findModel($id);
        Yii::$app->api->sendSuccessResponse($model->attributes);
    }

    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->api->sendSuccessResponse($model->attributes);
    }

    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        } else {
            Yii::$app->api->sendFailedResponse("Invalid Record requested");
        }
    }
}