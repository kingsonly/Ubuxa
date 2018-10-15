<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Invoice;
use frontend\models\FolderComponent;
use frontend\models\Component;
use frontend\models\Folder;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Receivedpurchaseorder;
use frontend\models\Currency;
use yii\helpers\ArrayHelper;
use boffins_vendor\classes\BoffinsBaseController;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends BoffinsBaseController
{
    /**
     * @inheritdoc
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
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
		$model = new Invoice();
		$findOneInvoice = $model->find()->orderBy(['id'=>SORT_ASC])->one();
        $dataProvider = new ActiveDataProvider([
            'query' => Invoice::find(),
        ]);
		$subComponents = $model->subComponents; 

        return $this->renderAjax('index', [
            'dataProvider' => $dataProvider,
			'model' => $model,
			'findOneInvoice' => $findOneInvoice,
			'subComponents' => $subComponents
			
        ]);
    }
	
	public function actionInvoicelistview()
    {
		$model = new Invoice();
		if(isset($_POST['option'])){
			$option = $_POST['option'];
			$hoverEffect = 'false';
			$dataProvider = Invoice::find()->where(['in','component_id',array_values(unserialize($option))])->all();
		} else {
			$hoverEffect = 'true';
			$dataProvider = Invoice::find()->all();
		}

        return $this->renderAjax('invoicelistview', [
            'invoice' => $dataProvider,
			'hoverEffect' => $hoverEffect,
			'model' => $model,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
	public function actionInvoiceview($id)
    {
		$model = new Invoice();
		$getSpecificInvoice = $model ->findOne($id);
		
		if($id == 0 or $id === 0){
			return $this->renderAjax('/nodata/nodataavailable',['message'=>'No Invoice available']);
		}
		
        return $this->renderAjax('view', [
            'model' => $getSpecificInvoice,
			'subComponents' => $getSpecificInvoice->subComponents
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoice();
		$FolderComponent = new FolderComponent();
		$receivedpurchaseorders['Quotation'] = 'Quotation';
		$receivedpurchaseorders += ArrayHelper::map(Receivedpurchaseorder::find()->all(), 'receivedpurchaseorder_reference', 'RPONameString');
		$currencies = ArrayHelper::map(Currency::find()->all(), 'id', 'currencyString');
		$folder = ArrayHelper::map(Folder::find()->all(), 'tyc_ref', 'tycDescription');
		$currency_settings = [
			'name' => 'masked-input',
			'clientOptions' => [
				'alias' => 'decimal',
				'digits' => 2,
				'digitsOptional' => false,
				'radixPoint' => '.',
				'groupSeparator' => ',',
				'autoGroup' => true,
				'removeMaskOnSubmit' => true,
			],
		];
		if(isset($_GET['id'])){
			$getId = $_GET['id'];
			if(!empty($model->itemType) && !empty($model->itemID)){
				$model->itemType = $model->itemType.',folder';
				$this->owner->itemID = $model->itemID.','.$getId;
			} else{
				$model->itemType = 'folder';
				$model->itemID = $getId;
			}
		}
        if ($model->load(Yii::$app->request->post())  && $model->save()) {
			$data=[];
			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			$data['sent'] = 'sent';
			$data['message'] = 'New invoice was created with invoice reference  '.$model->invoice_reference  ;
			return $data;
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
				'receivedpurchaseorders' => $receivedpurchaseorders,
				'currencies' => $currencies,
				'currency_settings' => $currency_settings,
				'language' => $this->language,
				'FolderComponent' => $FolderComponent,
				'folder' => $folder,
            ]);
        }
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$receivedpurchaseorders['Quotation'] = 'Quotation';
		$receivedpurchaseorders += ArrayHelper::map(Receivedpurchaseorder::find()->all(), 'receivedpurchaseorder_reference', 'RPONameString');
		$currencies = ArrayHelper::map(Currency::find()->all(), 'id', 'currencyString');
		$currency_settings = [
			'name' => 'masked-input',
			'clientOptions' => [
				'alias' => 'decimal',
				'digits' => 2,
				'digitsOptional' => false,
				'radixPoint' => '.',
				'groupSeparator' => ',',
				'autoGroup' => true,
				'removeMaskOnSubmit' => true,
			],
		];

        if ($model->load(Yii::$app->request->post()) ) {
			$model->save();
			
			$data=[];
			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			$data['sent'] = 'sent';
			$data['message'] = 'Updated invoice with invoice reference  '.$model->invoice_reference  ;
			return $data;
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
				'receivedpurchaseorders' => $receivedpurchaseorders,
				'currencies' => $currencies,
				'currency_settings' => $currency_settings,
				'language' => $this->language,
            ]);
        }
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	/**
	 * CHANGES BY BOFFINS TEAM 
	 */
	
	public $language;		//added by Anthony
	
	//functions by Anthony
	public function init() 
	{
		$this->language = [];
		$this->language['currencyDropDownPrompt'] = "Choose a Currency";
		$this->language['RPODropDownPrompt'] = "Choose an LPO/FPO or internal order";
	}

	
	

}
