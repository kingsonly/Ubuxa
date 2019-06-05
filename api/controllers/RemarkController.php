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

     public function actionIndex()
    {
           
                $model = new Remark();
                $perpage=10;
        

                if(Yii::$app->request->post('page')){
                    $numpage = Yii::$app->request->post('page');
                    $ownerid = Yii::$app->request->post('ownerId');
                    $modelName = Yii::$app->request->post('modelName');
                    $offset = (($numpage-1) * $perpage);
                    $remarkss = new Remark();
                    $remarkss->fromWhere = 'folder';
                    $remarkReply = Remark::find()->andWhere(['<>','parent_id', 0])->orderBy('id DESC')->all();
                    

                         
                    $remarks = $remarkss->specificClips($ownerid,1,$offset,$perpage,'remark');
                    $arr = [];
                    $reply = [];
                    for($i = 0 ; $i<count($remarks); $i++){
                        $fake = [];
                        foreach($remarks[$i]->reply as $key => $value){
                            $test = ['name' => $remarks[$i]->reply[$key]->fullname,
                                     'id' => $remarks[$i]->reply[$key]->id,
                                     'description' => $remarks[$i]->reply[$key]->text,
                                     'time' => $remarks[$i]->reply[$key]->timeElapsedString
                                    ];
                            array_push($fake, $test);
                        }
                                $arr[$i]['id'] = $remarks[$i]['id'];
                                $arr[$i]['name'] = $remarks[$i]->fullname;
                                $arr[$i]['description'] = strip_tags($remarks[$i]['text']);
                                $arr[$i]['time'] = $remarks[$i]->timeElapsedString;
                                $arr[$i]['editable'] = false;
                                $arr[$i]['replies'] = $fake;//$remarks[$i]->reply;

                        // for($j=0; $j<count($remarkReply); $j++ ){
                        //     if($remarks[$i]['id'] == $remarkReply[$j]['parent_id']){
                                
                        //         $reply[$j]['name'] = $remarkReply[2]->fullname;
                        //         $reply[$j]['description'] = strip_tags($remarkReply[$j]['text']);
                        //         $reply[$j]['time'] = $remarkReply[$j]->timeElapsedString;
                        //         //$reply[$j]['editable'] = false;
                        //         $arr[$i]['replies'] = array_values($reply);
                                
                        //     }
                        // }
                        
                    }
                    return Yii::$app->apis->sendSuccessResponse($arr);
                    
                    
                } else {
                    return Yii::$app->apis->sendFailedResponse($model->errors);
                }
            
    }

    public function actionCreate()
    {
        $model = new Remark();
        $commenterUserId = Yii::$app->user->identity->id;
        $commenterPersonId = Yii::$app->user->identity->person_id;
        $model->user_id = $commenterUserId;
        $model->person_id = $commenterPersonId;
        $model->text = Yii::$app->request->post('text');
        $model->remark_date = new Expression('NOW()');
        $model->attributes = $this->request;

        if (!empty($model->attributes)) {
            if($model->save()){
                $user = [];
                $userImage = UserDb::find()->andWhere(['id'=>$commenterUserId])->one();
                $user_names = Person::find()->andWhere(['id'=>$commenterPersonId])->one();
                $userImage = UserDb::find()->andWhere(['id'=>$commenterUserId])->one();
                $userInfo = UserDb::findOne($commenterUserId);
                $remarkId = $model->id;
                $remarkReply = $model->parent_id;
                $user['name'] = $user_names['first_name'].' '.$user_names['surname'];
                $date = Remark::find()->andWhere(['id'=>$remarkId])->one();
                $user['description'] = $model->text;
                $user['time'] = $date->timeElapsedString;
                $user['editable'] = false;
                $user['replies'] = [];
                $user['id'] = $model->id;
                $user['user_image'] = $userImage['profile_image'];
                $user['parent_id'] = $model->parent_id;
                return Yii::$app->apis->sendSuccessResponse($user);
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
        if(empty($model)){
            return Yii::$app->apis->sendFailedResponse('Remark does not exist');
        }else{
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
        if (($model = Remark::findOne($id)) !== null) {
            return $model;
        } else {
            Yii::$app->api->sendFailedResponse("Invalid Record requested");
        }
    }
}