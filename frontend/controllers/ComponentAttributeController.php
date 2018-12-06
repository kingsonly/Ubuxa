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
		$data2 = new ModelCollection( [], [ 'query' => ComponentAttribute::find() ] );
		$data3 = $data2->models;
		$data4 = count($data3);
		
		Yii::trace("Attempting to load and save a model 20");
		//this is how to set a ValueInteger. 
		$data2->loadModel(1, ['value' => 5655 ] ); //first parameter is the key, second parameter is the value. 
		$data2->saveModel(1);
		
		//this is how to set a ValueShortString. 
		$data2->loadModel(5, ['value' => "this is a short string" ] ); //first parameter is the key, second parameter is the value. 
		$data2->saveModel(5);
		
		//this is how to set a ValueLongString. 
		$data2->loadModel(3, ['value' => "this is a long string" ] ); //first parameter is the key, second parameter is the value. 
		$data2->saveModel(3);
		
		//this is how to set a ValueKnownClass. Remeber that the namespace you provide MUST implement "KnownClass"
		$data2->loadModel(15, ['value' => array('condition' => 'id=2', 'namespace'=>'frontend\models\Supplier') ] ); //first parameter is the key, second parameter is the value. 
		$data2->saveModel(15);
		
		$data2->loadModel(20, ['value' => array('condition' => 'id = 31', 'namespace'=>'frontend\models\Country') ] ); //first parameter is the key, second parameter is the value. 
		$data2->saveModel(20);
		
		//this is how to set a ValueMoney
		$data2->loadModel(11, ['value' => 15325.4 ] ); //first parameter is the key, second parameter is the value. 
		$data2->saveModel(11);
		
		Yii::trace("Did it work? " . (string)$data2->saveModel(1) ); //just supply the key.
		$data4 = $data2->models;
		
		$revised = new ModelCollection( [], [ 'query' => ComponentAttribute::find() ] );
		$revised2 = $revised->models;
		
		//$test = \frontend\models\ComponentTemplateAttribute::getValueClassName();
		//$test->getValueClassName();
		

        return $this->render('index-test', [
            'models' => $data4,
			'usesQuery' => $data2->usesQuery(),
			'query' => $data2->query,
			'revised' => $revised2,
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
