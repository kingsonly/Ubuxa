<?php

namespace api\controllers;


use yii\filters\AccessControl;
use api\behaviours\Verbcheck;
use api\behaviours\Apiauth;
use frontend\models\UserDb;
use Yii;
use yii\db\Expression;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\helpers\Url;



class UsersController extends RestController
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
		
		$initModdel = new UserDb();
        $model = $initModdel->find()->all();
		if(empty($model)){
			 return Yii::$app->apis->sendFailedResponse('There are no user');
		}else{
			$users = [];
			foreach($model as $key => $value){
				$users[$value->id] =  $value['attributes'];
                $users[$value->id]['email'] =  $value->email;
                $users[$value->id]['profile_image'] = 'http://192.168.1.6/ubuxa-beta/frontend/web/'.$value['profile_image'];
				$users[$value->id]['default_image'] = str_replace("localhost","192.168.1.6",Url::base(true)).'/images/users/default-user.png';
				$users[$value->id]['telephone'] =  $value['telephone'] ;
                $users[$value->id]['fullname'] =  $value['fullName'] ;
				unset($users[$value->id]['authKey']);
				unset($users[$value->id]['salt']);
				unset($users[$value->id]['password_hash']);
				unset($users[$value->id]['password']);
				unset($users[$value->id]['password_reset_token']);
			}
			return Yii::$app->apis->sendSuccessResponse($users);
			
		}
        
    }

	public function actionView($id)
    {
		
        $model =  $this->findModel($id);
		if(!empty($model)){
			$users = [];
			$users =  $model['attributes'];
			$users['email'] =  $model->email;
            $users['telephone'] =  $model['telephone'] ;
            $users['fullname'] =  $model['fullName'] ;
			$users['profile_image'] =  'http://192.168.1.6/ubuxa-beta/frontend/web/'.$model['profile_image'] ;
			unset($users['authKey']);
			unset($users['salt']);
            unset($users['password_hash']);
            unset($users['password']);
            unset($users['password_reset_token']);
			return Yii::$app->apis->sendSuccessResponse($users);
		}else{
			return Yii::$app->apis->sendFailedResponse('there is no user with this id ');
		}
	}

    public function actionUpdate($id)
    {
		
        $model =  $this->findModel($id);
        $person = $model->person;
        $model->attributes = $this->request;
		$person->attributes = $this->request;
        
		if(!empty($model->attributes)){

			if ($model->save() && $person->save(false)) {
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

    public function actionUpdateUserImage($id)
    {
        
        $model =  $this->findModel($id);
        $model->controlerLocation = 'API';
        $model->attributes = $this->request;
        if(!empty($model)){
            if (Yii::$app->request->isPost) {
                $model->profile_image = UploadedFile::getInstanceByName('profile_image');
                
                if ($model->upload()) {
                    // file is uploaded successfully
                    if($model->save()){
                        $response = ['msg' => 'created'];
                        return Yii::$app->apis->sendSuccessResponse($model->attributes,$response);
                    } else{
                        return Yii::$app->apis->sendFailedResponse(['did not create']);
                    }

                }
            }
            

        }else{
            return Yii::$app->apis->sendFailedResponse(['you dont have access to this folder']);
        }
        
    }
	
	public function actionDelete($id)
    {
        
    }

    protected function findModel($id)
    {
        if (($model = UserDb::findOne($id)) !== null) {
            return $model;
        } else {
            return Yii::$app->apis->sendFailedResponse("Invalid Record requested");
        }
    }
}