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
        $uploadPath = 'images/edocuments/';
        $cid = Yii::$app->user->identity->cid;
        $userId = Yii::$app->user->identity->id;
        if (isset($_FILES[$fileName])) {
            $cidDir = $uploadPath. $cid;
            $userDir = $cidDir.'/'.$userId;
            $dir = $userDir.'/'. date('Ymd');
            if (!file_exists($cidDir) && !is_dir($cidDir)) {
                FileHelper::createDirectory($cidDir);         
            }
            if(file_exists($cidDir) && is_dir($cidDir) && !file_exists($userDir) && !is_dir($userDir)){
                FileHelper::createDirectory($userDir); 
            }
            $file = UploadedFile::getInstanceByName($fileName);
            
            $data = Yii::$app->request->post();
            $reference =  $data['reference'];
            $referenceID =  $data['referenceID'];
            if (file_exists($dir) && is_dir($dir)) {
                $filePath = $model->checkFileName($dir, $file);
                if ($file->saveAs($filePath)){
                    $model->upload($model, $reference, $referenceID, $filePath, $cid);
                }
            }else{
                FileHelper::createDirectory($dir, $mode = 0775, $recursive = true);
                $filePath = $dir . '/' . $file->name;
                
                if ($file->saveAs($filePath)) {
                    $model->upload($model, $reference, $referenceID, $filePath, $cid);
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
            $id =  $data['id'];
            $model = $this->findModel($id)->delete();
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
