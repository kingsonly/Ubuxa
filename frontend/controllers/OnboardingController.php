<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Onboarding;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OnboardingController implements the CRUD actions for Onboarding model.
 */
class OnboardingController extends Controller
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
     * Lists all Onboarding models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Onboarding::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Onboarding model.
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
     * Creates a new Onboarding model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Onboarding();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Onboarding model.
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
     * Deletes an existing Onboarding model.
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

    public function actionTaskonboarding()
    {
       if(Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();   
            $id =  $data['user_id'];
            $onboarding = new Onboarding();
            $exists = $onboarding->find()->where(['user_id' => $id, 'group_id' => Onboarding::TASK_ONBOARDING])->exists();
            if($exists){
                $onboardingModel = $onboarding->find()->where(['user_id' => $id, 'group_id' => Onboarding::TASK_ONBOARDING])->one();
                $userid = $onboardingModel->id;
                $updateModel = $this->findModel($userid);
                $updateModel->status = Onboarding::ONBOARDING_COUNT;
                $updateModel->save();  
            }else{
                $onboarding->group_id = Onboarding::TASK_ONBOARDING;
                $onboarding->user_id = $id;
                $onboarding->status = 1;
                $onboarding->save();
            }
        }
    }

    public function actionRemarkonboarding()
    {
       if(Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();   
            $id =  $data['user_id'];
            $onboarding = new Onboarding();
            $exists = $onboarding->find()->where(['user_id' => $id,'group_id' => Onboarding::REMARK_ONBOARDING])->exists();
            if($exists){
                $onboardingModel = $onboarding->find()->where(['user_id' => $id, 'group_id' => Onboarding::REMARK_ONBOARDING])->one();
                $userid = $onboardingModel->id;
                $updateModel = $this->findModel($userid);
                $updateModel->status = Onboarding::ONBOARDING_COUNT;
                $updateModel->save();  
            }else{
                $onboarding->group_id = Onboarding::REMARK_ONBOARDING;
                $onboarding->user_id = $id;
                $onboarding->status = 1;
                $onboarding->save();
            }
        }
    }

    public function actionFolderdetailsonboarding()
    {
       if(Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();   
            $id =  $data['user_id'];
            $onboarding = new Onboarding();
            $exists = $onboarding->find()->where(['user_id' => $id,'group_id' => Onboarding::FOLDER_ONBOARDING])->exists();
            if($exists){
                $onboardingModel = $onboarding->find()->where(['user_id' => $id, 'group_id' => Onboarding::FOLDER_ONBOARDING])->one();
                $userid = $onboardingModel->id;
                $updateModel = $this->findModel($userid);
                $updateModel->status = Onboarding::ONBOARDING_COUNT;
                $updateModel->save();  
            }else{
                $onboarding->group_id = Onboarding::FOLDER_ONBOARDING;
                $onboarding->user_id = $id;
                $onboarding->status = 1;
                $onboarding->save();
            }
        }
    }

    public function actionSubfoldersonboarding()
    {
       if(Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();   
            $id =  $data['user_id'];
            $onboarding = new Onboarding();
            $exists = $onboarding->find()->where(['user_id' => $id,'group_id' => Onboarding::SUBFOLDER_ONBOARDING])->exists();
            if($exists){
                $onboardingModel = $onboarding->find()->where(['user_id' => $id, 'group_id' => Onboarding::SUBFOLDER_ONBOARDING])->one();
                $userid = $onboardingModel->id;
                $updateModel = $this->findModel($userid);
                $updateModel->status = Onboarding::ONBOARDING_COUNT;
                $updateModel->save();  
            }else{
                $onboarding->group_id = Onboarding::SUBFOLDER_ONBOARDING;
                $onboarding->user_id = $id;
                $onboarding->status = 1;
                $onboarding->save();
            }
        }
    }

    public function actionMainonboarding()
    {
       if(Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();   
            $id =  $data['user_id'];
            $onboarding = new Onboarding(); 
            $onboarding->group_id = Onboarding::MAIN_ONBOARDING;
            $onboarding->user_id = $id;
            $onboarding->status = 1;
            $onboarding->save();
        }
    }

    /**
     * Finds the Onboarding model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Onboarding the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Onboarding::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
