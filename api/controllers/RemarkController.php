<?php

namespace api\controllers;


use yii\filters\AccessControl;
use api\behaviours\Verbcheck;
use api\behaviours\Apiauth;
use frontend\models\UserDb;
use frontend\models\Person;
use frontend\models\Remark;
use Yii;
use yii\db\Expression;



class RemarkController extends RestController
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
        $model = new Remark();
        $commenterUserId = Yii::$app->user->identity->id;
        $commenterPersonId = Yii::$app->user->identity->person_id;
        $model->user_id = $commenterUserId;
        $model->person_id = $commenterPersonId;
        $model->remark_date = new Expression('NOW()');
        $model->attributes = $this->request;

        if (!empty($model->attributes)) {
            if($model->save()){
                $userImage = UserDb::find()->andWhere(['id'=>$commenterUserId])->one();
                $user_names = Person::find()->andWhere(['id'=>$commenterPersonId])->one();
                $remarkId = $model->id;
                $remarkReply = $model->parent_id;
                return Yii::$app->apis->sendSuccessResponse([ $userImage['profile_image'],$user_names['first_name'].' '.$user_names['surname'],$remarkId, $remarkReply, $model->text]);
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

    public function actionUpdate($id)
    {
        
        $model =  $this->findModel($id);
        $model->attributes = $this->request;
        if(!empty($model->attributes)){
            if ($model->save()) {
               return Yii::$app->apis->sendSuccessResponse($model->attributes);
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
        if(empty($model)){
            Yii::$app->api->sendFailedResponse('Remark does not exist');
        }else{
            if($model->delete()){
                return Yii::$app->apis->sendSuccessResponse($model->attributes);
            }else{
                if (!$model->validate()) {
                    Yii::$app->api->sendFailedResponse($model->errors);
                }
            }
        }
    }

    protected function findModel($id)
    {
        if (($model = Remark::findOne($id)) !== null) {
            return $model;
        } else {
            Yii::$app->api->sendFailedResponse("Invalid Record requested");
        }
    }
}