<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ComponentAttribute;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use boffins_vendor\classes\ModelCollection;
use boffins_vendor\classes\StandardQuery;
use frontend\models\Folder;

/**
 * ComponentAttributeController implements the CRUD actions for ComponentAttribute model.
 */
class ComponentAttributeController extends Controller
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
     * Lists all ComponentAttribute models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ComponentAttribute::find(),
        ]);
		

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
	
    /**
     *  @brief Useless action. 
     *  Just testing features here.
     */
    public function actionTest()
    {
		$folderModel = new Folder();
		$getFolder = $folderModel->find()->where(['id'=>30])->one();
		$getFolder->externalTemplateId = 5;
		//return $this->renderAjax('listview',['content'=>$getFolder->componentTemplateAsComponents]);
		
		$data2 = new ModelCollection( [], [ 'query' => $getFolder->getComponentTemplateAsComponents() ] );
		$data3 = $data2->models;
		$data4 = count($data3);
		
		$data2->loadModel(0, ['name' => "New Name Here"] );
		

        return $this->render('index-test', [
            'models' => $data3,
			'usesQuery' => $data2->usesQuery(),
			'query' => $data2->query,
        ]);
    }

    /**
     * Displays a single ComponentAttribute model.
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
     * Creates a new ComponentAttribute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ComponentAttribute();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ComponentAttribute model.
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
     * Deletes an existing ComponentAttribute model.
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
     * Finds the ComponentAttribute model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ComponentAttribute the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ComponentAttribute::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('component', 'The requested page does not exist.'));
    }
}