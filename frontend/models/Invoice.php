<?php

namespace frontend\models;

use Yii;
use yii\db\Expression;
use frontend\models\Currency;
use frontend\models\FolderComponent;
use boffins_vendor\classes\FolderSubComponentARModel;
use boffins_vendor\behaviors\DeleteUpdateBehavior;
use boffins_vendor\behaviors\DateBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "{{%invoice}}".
 *
 * @property integer $id
 * @property integer $component_id 
 * @property string $invoice_reference
 * @property string $receivedpurchaseorder_id
 * @property string $description
 * @property string $amount
 * @property integer $currency_id
 * @property string $creation_date
 * @property string $last_updated 
 * @property integer $deleted 
 
 * @property Currency $currency
 * @property Receivedpurchaseorder $receivedpurchaseorder
 * @property Component $component
 * @property InvoiceComponent[] $InvoiceComponents 
 
 */
		

class Invoice extends FolderSubComponentARModel
{
	
    /**
     * @inheritdoc
     */
	const COMPONENT_TYPE = "invoice";
	public $softDeleted = false;
	public $folderComponentItems = array();
	public $foldersList;
	public $defaltBehaviour = FALSE;
    public static function tableName()
    {
        return '{{%invoice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'amount', 'currency_id'], 'required'],
            [['currency_id'], 'integer'],
            [['amount', 'invoice_reference'], 'string'],
            [['currency_id'], 'safe'],
            [['creation_date', 'last_updated','itemType', 'itemID','upload_file'], 'safe'],
            [['receivedpurchaseorder_id'], 'string', 'max' => 16],
            [['description'], 'string', 'max' => 255],
          
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'receivedpurchaseorder_id' => 'Received Purchase Order',
            'description' => 'Description',
            'amount' => 'Amount',
            'currency_id' => 'Currency',
            'creation_date' => 'Creation Date',
            'invoice_reference' => 'Invoice Reference'
        ];
    }
	
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return 1233;
    }
	
	public function getDescriptions()
    {
        return $this->description;
        
    }
	
	public function getCurrencyAndAmount()
    {
        return 1234;
    }
	
	

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceivedPurchaseOrder()
    {
		if ($this->receivedpurchaseorder_reference === 'Quotation' ) {
			return $this->receivedpurchaseorder_reference;
		}
        return $this->hasOne(Receivedpurchaseorder::className(), ['receivedpurchaseorder_reference' => 'receivedpurchaseorder_id']);
    }
    
    /**
	 * CHANGES BY BOFFINS TEAM 
	 */
	 
	//added by Anthony

	//functions by Anthony	

	public function getComponent() 
	{
		return $this->hasOne(Component::className(), ['id' => 'component_id']);
	}
	
	
	
	//fetch the total number of projects added by Kingsley
    public function allRecords() {
        return Count($this->find()->all());
    }
		   
	public function getCurrencies() {
		return Currency::find()->all();
	}
	
	public function getReceivedpurchaseorders() {
		return Receivedpurchaseorder::find()->all();
	}
	
	public function beforeValidate() 
	{ 
		static $componentSet = false;
		$this->last_updated = date('Y-m-d'); 
		if ($this->isNewRecord) {
			$this->deleted = 0;
			return parent::beforeValidate();
		}
		//return parent::beforeValidate();
	}
	
	private function _setFolderComponentItemsComponentId() 
	{
		foreach ($this->folderComponentItems as $item) {
			$item->component_id = $this->component_id;
		}
	}
	
	public function myBehaviors() 
	{
		return [
			'deleteUpdateBehavior2' => [
					'class' => DeleteUpdateBehavior::className(),
			],
			"dateValues" => [
				"class" => DateBehavior::className(),
				"AREvents" => [
						ActiveRecord::EVENT_BEFORE_VALIDATE => [ 'rules' => [
																			DateBehavior::DATE_CLASS_STAMP => [
																					'attributes' => ['last_updated', ],
																					],
																			/*DateBehavior::DATE_CLASS_STANDARD => [
																					'attributes' => ['creation_date']
																					]*/
																				] 
															],
						ActiveRecord::EVENT_AFTER_FIND => [ 'rules' => [
																			DateBehavior::DATE_CLASS_STANDARD => [
																					'attributes' => ['last_updated', 'creation_date'],
																					],
																				] 
															],
					],
			],
		];

	}


	
}
