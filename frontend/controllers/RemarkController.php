<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use frontend\models\Remark;
use frontend\models\Person;
use frontend\models\UserDb;
use frontend\models\Folder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use boffins_vendor\classes\BoffinsBaseController;
/**
 * RemarkController implements the CRUD actions for Remark model.
 */
class RemarkController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Remark models.
     * @return mixed
     */
    public function actionIndex()
    {
        $perpage=10;
        

        if(isset($_GET['src'])){
            if(Yii::$app->request->post('page')){
                $numpage = Yii::$app->request->post('page');
                $ownerid = Yii::$app->request->post('ownerId');
                $modelName = Yii::$app->request->post('modelName');
                $DashboardUrlParam = Yii::$app->request->post('DashboardUrlParam');
                $offset = (($numpage-1) * $perpage);
                $remarkss = new Remark();
                $remarkss->fromWhere = 'folder';
                $remarkReply = Remark::find()->andWhere(['<>','parent_id', 0])->orderBy('id DESC')->all();
                
                //if url is site index get all the remarks
                if($DashboardUrlParam == 'site'){
                     $remarks = Remark::find()->andWhere(['parent_id' => 0])->limit($perpage)->offset($offset)->orderBy('id DESC')->all();
					
                     return $this->renderAjax('siteremarks', [
						 'remarks' => $remarks,
						 'remarkReply' => $remarkReply,
                     ]);
                } else {
                     
                     $remarks = $remarkss->specificClips($ownerid,1,$offset,$perpage,'remark');
                     return $this->renderAjax('index2', [
						 'remarks' => $remarks,
						 'remarkReply' => $remarkReply,
					 ]);
                }
                
            } 
        }
    }

    /**
     * Displays a single Remark model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Remark model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Remark();
        $commenterUserId = Yii::$app->user->identity->id;
        $commenterPersonId = Yii::$app->user->identity->person_id;
        $model->user_id = $commenterUserId;
        $model->person_id = $commenterPersonId;
        if(!empty(Yii::$app->request->post('&moredata'))){
            $model->text = Yii::$app->request->post('&moredata');
        } else {
            return 'field cannot be empty';
        }
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $remarkSaved = "remark saved successfully";
             $userImage = UserDb::find()->andWhere(['id'=>$commenterUserId])->one();
             $user = UserDb::findOne($commenterUserId);
             $personName = $user->fullname;
             //$user_names = Person::find()->andWhere(['id'=>$commenterPersonId])->one();
             $remarkId = $model->id;
             $remarkReply = $model->parent_id;
             return json_encode([ $userImage['profile_image'],$personName,$remarkId, $remarkReply]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Remark model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Remark model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionMention($id){
        $owner = $id;
        $users = new Folder();
        $getUsers = $users->find()->andWhere(['id' => $owner])->one();
        $name = array();
        $names = ['nnamdi','ogundu','uchechukwu'];
        foreach ($getUsers->users as $user) {
            $name[] = $user->fullname;
        }
       return json_encode($name);
    }

    public function actionHashtag(){
        $folder = Folder::find()->select(['id as name','title as content'])->asArray()->all();
        return json_encode($folder);
    }

    /**
     * Finds the Remark model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Remark the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Remark::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
