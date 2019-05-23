<?php

namespace api\controllers;


use yii\filters\AccessControl;
use api\behaviours\Verbcheck;
use api\behaviours\Apiauth;
use frontend\models\UserDb;
use Yii;
use yii\db\Expression;
use yii\helpers\Json;



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
				$users[$value->id]['telephone'] =  $value['telephone'] ;
                $users[$value->id]['fullName'] =  $value['fullName'] ;
                $users[$value->id]['profile_image'] =  $value['profile_image'] ;
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