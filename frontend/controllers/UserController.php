<?php

namespace frontend\controllers;

use Yii;
use frontend\models\UserDb;
use frontend\models\Person;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use boffins_vendor\classes\BoffinsBaseController;
/**
 * UserController implements the CRUD actions for UserDb model.
 */
class UserController extends BoffinsBaseController
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
     * Lists all UserDb models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new UserDb();
        $dataProvider =$model->find()->all();
        return $this->renderAjax('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserDb model.
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
     * Creates a new UserDb model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserDb();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserDb model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {   
        $id = Yii::$app->user->identity->id;
        $model = $this->findModel($id);
        $person = $model->person;

        if ($model->load(Yii::$app->request->post())) {
            $model->profile_image = UploadedFile::getInstance($model, 'profile_image');
            if(!empty($model->profile_image)){
                $fileName = $model->username.rand(1, 4000) . '.' . $model->profile_image->extension;
                $filePath = 'images/users/'.$fileName;
                $model->profile_image->saveAs($filePath);
                $model->profile_image = $filePath;
            }
            $model->save(false);
            //return $this->redirect(['view', 'id' => $model->id]);
        }



            // Check if there is an Editable ajax request
        if (isset($_POST['hasEditable'])) {
            // use Yii's response format to encode output as JSON
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            // read your posted model attributes
            if ($person->load(Yii::$app->request->post())) {
                // read or convert your posted information
                
                $person->save(false);
                // return JSON encoded output in the below format
                return ['output'=>'', 'message'=>''];
                
                // alternatively you can return a validation error
                // return ['output'=>'', 'message'=>'Validation error'];
            }
            // else if nothing to do always return an empty JSON encoded output
            else {
                return ['output'=>'', 'message'=>''];
            }
        }
            return $this->renderAjax('update', [
                'model' => $model,
                'person' => $person,
            ]);
    }

    public function actionUpload()
    {
        $id = Yii::$app->user->identity->id;
        $username = Yii::$app->user->identity->username;
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post(), '')) {
            $model->profile_image = UploadedFile::getInstanceByName('profile_image');
            if(!empty($model->profile_image)){
                $fileName = $model->username.rand(1, 4000) . '.' . $model->profile_image->extension;
                $filePath = 'uploads/'.$fileName;
                $model->profile_image = $filePath;
                $model->profile_image->saveAs($filePath);
            }else{
                $model->profile_image = 'test';
            }
        }
    }

    /**
     * Deletes an existing UserDb model.
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

    /**
     * Finds the UserDb model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserDb the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserDb::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
