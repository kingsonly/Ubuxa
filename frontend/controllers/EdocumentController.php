<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Edocument;
use frontend\models\Folder;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\db\Expression;
use boffins_vendor\classes\BoffinsBaseController;

/**
 * EdocumentController implements the CRUD actions for Edocument model.
 */
class EdocumentController extends Controller
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
     * Lists all Edocument models.
     * @return mixed
     */
    public function actionIndex($folderId)
    {
        $folder = Folder::findOne($folderId);
        $edocument = $folder->clipOn['edocument'];

        return $this->renderAjax('index', [
            'edocument' => $edocument,
        ]);
    }

    /**
     * Displays a single Edocument model.
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
     * Creates a new Edocument model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Edocument();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @brief Uploads an edocument file 
     * @details This methods uploads files to the server and also saves the path to the database.
     */
    public function actionUpload()
    {
        $model = new Edocument();
        $fileName = 'file';
        $cid = Yii::$app->user->identity->cid;
        $uploadPath = 'images/';
        $cidPath = 'edocuments/'.$cid; //set path with customer id
        $userId = Yii::$app->user->identity->id; //get user id
        if (isset($_FILES[$fileName])) {
            $data = Yii::$app->request->post();
            $reference =  $data['reference']; //get the location where the file was dropped
            $referenceId =  $data['referenceID']; //get the ID of the location where the file was dropped
            $model->documentUpload($fileName, $cid, $uploadPath, $cidPath, $userId, $reference, $referenceId);
        }

        return false;
    }

    /**
     * Updates an existing Edocument model.
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
     * Deletes an existing Edocument model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        if(Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();   
            $id =  $data['id']; //get id from post
            $model = $this->findModel($id);
            unlink($model->file_location); //delete file from folder path
            $model->delete();
        }
    }

    /**
     * Finds the Edocument model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Edocument the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Edocument::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
