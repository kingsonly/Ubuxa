<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Edocument;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\db\Expression;

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
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Edocument::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
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

    public function actionUpload()
    {
        $model = new Edocument();
        $fileName = 'file';
        $cid = Yii::$app->user->identity->cid;
        $uploadPath = 'images/';
        $cidPath = 'edocuments/'.$cid; //set path with customer id
        $userId = Yii::$app->user->identity->id; //get user id
        if (isset($_FILES[$fileName])) {
            $cidDir = $uploadPath. $cidPath; //set a varaible for customer id path
            $userDir = $cidDir.'/'.$userId; //set a varaible for user id path
            $dir = $userDir.'/'. date('Ymd'); //set a varaible for path with date

            /* check if  directory with customer id path exists, if not create one. In UNIX systems files are seen as directories hence the need to cheeck if !file_exists*/
            if (!file_exists($cidDir) && !is_dir($cidDir)) {
                FileHelper::createDirectory($cidDir);         
            }
            //check if  directory with user id path exists, if not create one
            if(file_exists($cidDir) && is_dir($cidDir) && !file_exists($userDir) && !is_dir($userDir)){
                FileHelper::createDirectory($userDir); 
            }
            $file = UploadedFile::getInstanceByName($fileName); //get uploaded instance of file
            
            $data = Yii::$app->request->post();
            $reference =  $data['reference']; //get the location where the file was dropped
            $referenceID =  $data['referenceID']; //get the ID of the location where the file was dropped

            //check if the directory with current date exist
            if (file_exists($dir) && is_dir($dir)) {
                $filePath = $model->checkFileName($dir, $file); //check if file name exist in that directory and append a number to it, if it does.
                if ($file->saveAs($filePath)){
                    $model->upload($model, $reference, $referenceID, $filePath, $cid); //upload
                }
            }else{
                FileHelper::createDirectory($dir, $mode = 0777, $recursive = true); //create directory with read and write permission
                $filePath = $dir . '/' . $file->name;
                
                if ($file->saveAs($filePath)) {
                    $model->upload($model, $reference, $referenceID, $filePath, $cid); //upload
                }            
            }
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
