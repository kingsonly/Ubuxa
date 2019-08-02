<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Onboarding;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use boffins_vendor\classes\BoffinsBaseController;

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

    /**
     * @brief Updates Onboarding model after onboarding
     * @details This methods checks if onboarding for a user already exists, if it does, it updates the count else
        it creates a new onboarding field for that user
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionOnboarding()
    {
       if(Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();   
            $userId =  $data['user_id'];
            $onboardingGroup =  $data['group'];
            $onboarding = new Onboarding();
            switch ($onboardingGroup) {
                case 'task':
                    $onboarding->updateOnboarding($userId, Onboarding::TASK_ONBOARDING_GROUP_ID);
                    break;
                case 'remark':
                    $onboarding->updateOnboarding($userId, Onboarding::REMARK_ONBOARDING_GROUP_ID);
                    break;
                case 'folderDetails':
                    $onboarding->updateOnboarding($userId, Onboarding::FOLDER_DETAILS_ONBOARDING_GROUP_ID);
                    break;
                case 'subfolders':
                    $onboarding->updateOnboarding($userId, Onboarding::SUBFOLDER_ONBOARDING_GROUP_ID);
                    break;
                default:
                    $onboarding->group_id = Onboarding::MAIN_DASHBOARD_ONBOARDING_GROUP_ID;
                    $onboarding->user_id = $userId;
                    $onboarding->status = 1;
                    $onboarding->save();
                    break;
            }
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
