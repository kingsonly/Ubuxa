<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Remark;
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
            if(Yii::$app->request->post('page')){
                $numpage = Yii::$app->request->post('page');
                $popsisi = (($numpage-1) * $perpage);
                $remarks = Remark::find()->where(['parent_id' => 0])->orderBy('id DESC')->limit($perpage)->offset($popsisi)->all();
                $remarkReply = Remark::find()->where(['<>','parent_id', 0])->orderBy('id DESC')->all();
                return $this->renderAjax('index2', [
                'remarks' => $remarks,
                'remarkReply' => $remarkReply,
                ]);
            } else {
                $numpage = 10;
                $remarks = Remark::find()->limit($numpage)->all();
                return $this->render('index', [
                'remarks' => $remarks,
                ]);
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
        $commenterId = Yii::$app->user->identity->person_id;
        $model->person_id = $commenterId;
        if(!empty(Yii::$app->request->post('&moredata'))){
            $model->text = Yii::$app->request->post('&moredata');
        } else {
            return 'field cannot be empty';
        }
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $remarkSaved = "remark saved successfully";
            return $remarkSaved;
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
