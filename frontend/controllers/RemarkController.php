<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Remark;
use frontend\models\RemarkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $perpage=4;
        if(isset($_GET['src'])){
        $searchModel = new RemarkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        //$popsis = (($numpage-1) * $perpage);
        if(Yii::$app->request->post('page')){
            $numpage = Yii::$app->request->post('page');
            $popsisi = (($numpage-1) * $perpage);
            $remarks = Remark::find()->limit($perpage)->offset($popsisi)->all();
            return $this->renderAjax('index2', [
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
            'remarks' => $remarks,
        ]);
        } else {
            $numpage = 10;
            $remarks = Remark::find()->limit($numpage)->all();
            return $this->render('index', [
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
            'remarks' => $remarks,
        ]);
        }


        
       
        
        
    }
     
        
    }

    public function actionRemark()
    {
            $remarks = Remark::find()->limit(10)->all();
            return $this->render('remark', [
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
            'remarks' => $remarks,
    ]);
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
        
         $getLocation = $model->trackLocation();
        
         $model->component_name = $getLocation[0];
         $model->view_id = 1;
        
         $commenterId = Yii::$app->user->identity->person_id;
         $model->person_id = $commenterId;
        if ($model->load(Yii::$app->request->post())) {
           if($model->save()){
            return $this->redirect(['view', 'id' => $model->id]);
           }
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
