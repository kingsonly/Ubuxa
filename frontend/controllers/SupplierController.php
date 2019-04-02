<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Supplier;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Corporation;
use frontend\models\Entity;
use frontend\models\Email;
use frontend\models\Address;
use frontend\models\Telephone;
use frontend\models\Country;
use frontend\models\EmailEntity;
use frontend\models\TelephoneEntity;
use frontend\models\State;
use yii\helpers\Json;
use yii\db\Exception;
use boffins_vendor\classes\BoffinsBaseController;
/**
 * SupplierController implements the CRUD actions for Supplier model.
 */
class SupplierController extends BoffinsBaseController
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
     * Lists all Supplier models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Supplier();
        $corporations = $model->corporation;
        $suppliers = $model->find()->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $model->find(),
        ]);

        return $this->renderAjax('index', [
            'dataProvider' => $dataProvider,
            'corporations' => $corporations,
            'model' => $model,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Displays a single Supplier model.
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
     * Creates a new Supplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Supplier();
        $coperationModel = new Corporation();
        $entityModel = new Entity();
        $emailModel = new Email();
        $addressModel = new Address();
        $telephoneModel = new Telephone();
        $country = new Country();
        $state = new State();
        $emailEntity = new EmailEntity();
        $telephoneEntity = new TelephoneEntity();

        $getCountries = json_encode($country->find()->all());
        $getStates = $state->find()->all();

        $entityModel->entity_type = 'corporation';
        if ($coperationModel->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post()) && $telephoneModel->load(Yii::$app->request->post()) && $emailModel->load(Yii::$app->request->post()) && $addressModel->load(Yii::$app->request->post())) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($entityModel->save()){
                    $coperationModel->entity_id = $entityModel->id;
                    $emailEntity->entity_id = $entityModel->id;
                    $telephoneEntity->entity_id = $entityModel->id;

                    if($coperationModel->save() && $telephoneModel->save(false) && $emailModel->save(false)){
                        $model->corporation_id = $coperationModel->id;
                        $telephoneEntity->telephone_id = $telephoneModel->id;
                        $emailEntity->email_id = $emailModel->id;
                        if ($model->save() && $telephoneEntity->save() && $emailEntity->save()) {
                            $transaction->commit();
                             exit(json_encode(array("status" => 1, "msg" => 'Supplier has been successfully created!')));
                        } else {
                            exit(json_encode(array("status" => 2, "msg" => 'Something went wrong!')));
                        }
                    } else {
                        //echo 'error2';
                    }
                } else {
                   //echo 'error3';
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        if(isset($_GET['src'])){
            if (Yii::$app->request->post('existingId')) {
                 $model->corporation_id = Yii::$app->request->post('existingId');
                 $model->supplier_type = 'supplier';
                 if($model->save()){
                        exit(json_encode(array("status" => 1, "msg" => 'Sent!')));
                 } else {
                        exit(json_encode(array("status" => 2, "msg" => 'Something went wrong!')));
                 }
            }
        }

        

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }*/

        /*
         *fetch existing corporation
        */

        $getExistingCorperation = $coperationModel->find()->all();

        return $this->renderAjax('create', [
            'model' => $model,
            'coperationModel' => $coperationModel,
            'entityModel' => $entityModel,
            'emailModel' => $emailModel,
            'addressModel' => $addressModel,
            'telephoneModel' => $telephoneModel,
            'countryModel' => $country,
            'getCountries' => $getCountries,
            'state' => $state,
            'getStates' => $getStates,
            'getExistingCorperation' => $getExistingCorperation,
        ]);
    }

    /**
     * Updates an existing Supplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSubcat()
    {
        $out = [];
        $state = new State();
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = $state::find()->select(['id','name'])->andWhere(['country_id' => $cat_id])->all(); 
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
    }
    echo Json::encode(['output'=>'', 'selected'=>'']);
    }
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
     * Deletes an existing Supplier model.
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
     * Finds the Supplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Supplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supplier::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
