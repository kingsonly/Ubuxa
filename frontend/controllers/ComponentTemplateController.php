<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ComponentTemplate;
use frontend\models\ComponentAttributeType;
use frontend\models\ComponentTemplateAttribute;
use frontend\models\AttrModel;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComponentTemplateController implements the CRUD actions for ComponentTemplate model.
 */
class ComponentTemplateController extends Controller
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
     * Lists all ComponentTemplate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ComponentTemplate::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ComponentTemplate model.
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
     * Creates a new ComponentTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   /* public function actionCreate()
    {
        $model = new ComponentTemplate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }*/
	
	
	public function actionCreate()
    {
        $componentTemplate = new ComponentTemplate;
        $componentTemplateAttributeModel = [new ComponentTemplateAttribute];
		$attributeType = ArrayHelper::map(ComponentAttributeType::find()->all(), 'id', 'name');
        if ($componentTemplate->load(Yii::$app->request->post())) {

            $attributeModel = AttrModel::createMultiple(ComponentTemplateAttribute::classname());
            AttrModel::loadMultiple($attributeModel, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($attributeModel),
                    ActiveForm::validate($componentTemplate)
                );
            }

            // validate all models
            $valid = $componentTemplate->validate();
            $valid = AttrModel::validateMultiple($attributeModel) && $valid;
            
            if ($valid) {   
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $componentTemplate->save(false)) {
                        foreach ($attributeModel as $modelAddress) {
                            $modelAddress->component_template_id = $componentTemplate->id;
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $componentTemplate->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $componentTemplate,
            'attributeType' => $attributeType,
            'attributeModel' => (empty($attributeModel)) ? [new ComponentTemplateAttribute] : $attributeModel
        ]);
    }

    /**
     * Updates an existing ComponentTemplate model.
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
     * Deletes an existing ComponentTemplate model.
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
     * Finds the ComponentTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ComponentTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ComponentTemplate::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
