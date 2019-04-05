<?php

namespace api\controllers;


use yii\filters\AccessControl;
use api\behaviours\Verbcheck;
use api\behaviours\Apiauth;
use frontend\models\Folder;
use yii\web\UploadedFile;
use Yii;
use yii\db\Expression;



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
			$folderDetails  = $firstFolderFilter->attributes;
			foreach($firstFolderFilter->attributes as $key => $value){
				$folderDetails[$key] = $value;
			}
			$folderDetails['folderstatus'] = $folderStatus;
			$folderRole = $firstFolderFilter['role'];
			$folderDetails['role'] =  $folderRole['role'];
			$folderDetails['createdby'] = $firstFolderFilter->folderManagerByRole['user_id'];
			$folders[] =   (array) $folderDetails;
		}
        $response = $folders;
        Yii::$app->api->sendSuccessResponse($response);
		
    }
	
	public function actionFolderDetails($id)
    {
        $folder = Folder::find()->andWhere(['id' => $id])->one();
		if(!empty($folder)){
			if($folder->private_folder == $folder::DEFAULT_PRIVATE_FOLDER_STATUS){
			$folderStatus = 'public';
			}else{
				$folderStatus = 'private';
			}
			$folderDetails = (array) $folder->attributes;
			$folderDetails['folderstatus'] = $folderStatus;
			$folderRole = $folder['role'];
			$folderDetails['role'] =  $folderRole['role'];
			$folderDetails['createdby'] = $folder->folderManagerByRole['user_id'];
			$folderDetails['subfolders'] = $folder->subFolders;
			$folders[] =   $folderDetails;

			$response = $folders;
			Yii::$app->api->sendSuccessResponse($response);
		}else{
			$response = ['somthing went wrong'];
			Yii::$app->api->sendFailedResponse($response);
		}
		
		
    }
	
	public function actionSubfolder($id)
    {
        $folder = Folder::find()->andWhere(['id' => $id])->one();
		if(!empty($folder)){
			
			$folderDetails['subfolders'] = $folder->subFolders;
			$folders[] =   $folderDetails;

			$response = $folders;
			Yii::$app->api->sendSuccessResponse($response);
		}else{
			$response = ['somthing went wrong'];
			Yii::$app->api->sendFailedResponse($response);
		}
		
		
    }
	
	
	public function actionUpdateFolderImage($id)
    {
		
        $model =  $this->findModel($id);
		$model->controlerLocation = 'API';
		$model->attributes = $this->request;
		if(!empty($model)){
			if (Yii::$app->request->isPost) {
				$model->upload_file = UploadedFile::getInstanceByName('upload_file');
				
				if ($model->upload()) {
					
					// file is uploaded successfully
					if($model->save()){
						$response = ['msg' => 'created'];
						Yii::$app->api->sendSuccessResponse($model->attributes,$response);
					} else{
						Yii::$app->api->sendFailedResponse(['didnot create']);
					}

				}
        	}
			

		}else{
			Yii::$app->api->sendFailedResponse(['you dont have access to this folder']);
		}
        
	}

   public function actionCreate()
    {
        $model = new Folder();
		$model->attributes = $this->request;
        if (!empty($model->attributes['title'])) {
			$model->last_updated =  new Expression('NOW()');
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
				Yii::$app->api->sendFailedResponse(['could not create']);
			}
		}else{
			Yii::$app->api->sendFailedResponse(['you dont have access to this folder']);
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
        if (($model = Folder::findOne($id)) !== null) {
            return $model;
        } else {
            Yii::$app->api->sendFailedResponse("Invalid Record requested");
        }
    }
}