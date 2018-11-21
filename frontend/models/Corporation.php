<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\models\{StandardTenantQuery, TenantSpecific, TrackDeleteUpdateInterface};
use boffins_vendor\classes\BoffinsArRootModel;


//use app\models\Tmclient;

/**
 * This is the model class for table "{{%corporation}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $short_name
 * @property string $notes
 *
 * @property TmAddressCorporation[] $tmAddressCorporations
 * @property TmCategoroyCorporation[] $tmCategoroyCorporations
 * @property TmClient $tmClient
 * @property TmOrder[] $tmOrders
 * @property TmPayment[] $tmPayments
 * @property TmPayment[] $tmPayments0
 * @property TmPersonCorporation[] $tmPersonCorporations
 * @property TmProductCorporation[] $tmProductCorporations
 */
class Corporation extends BoffinsArRootModel implements TenantSpecific, TrackDeleteUpdateInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%corporation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'short_name'], 'required'],
            [['short_name'], 'string', 'max' => 5],
			[['name', 'notes'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'short_name' => 'Short Name',
            'notes' => 'Notes',
        ];
    }
	
	

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddressCorporations()
    {
        return $this->hasMany(AddressCorporation::className(), ['corporation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryCorporations()
    {
        return $this->hasMany(CategoroyCorporation::className(), ['corporation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['corporation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['supplier_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['receiver_corporation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments0()
    {
        return $this->hasMany(Payment::className(), ['payment_source_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonCorporations()
    {
        return $this->hasMany(PersonCorporation::className(), ['corporation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCorporations()
    {
        return $this->hasMany(ProductCorporation::className(), ['supplier_id' => 'id']);
        
    }
    //Added by kingsley of boffins 
    public static function getclientname($id)
    {
		$compid=Client::get_clientid($id) ;
        $client=Corporation::findOne(['id' => $compid,]);
        return $client->name;
    }
    
    public function get_corp_name()
    {
		$clientId=Client::get_all_clientid() ;
        $allClientArray=[];
 
        foreach($clientId as $clienIdKey=>$clienIdValue){
            array_push($allClientArray,$clienIdValue['corporation_id']);
       		}
		
        $client=Corporation::findAll(array_values($allClientArray));
        return $client;
    
    }
    
    public function get_supp_name()
	{
		$supid=Supplier::get_all_supplierid();
        $supp=[];
		
        foreach($supid as $sk=>$sv){
            array_push($supp,$sv['corporation_id']);
        }
		
		$client=Corporation::findAll(array_values($supp));
        return $client;
    }
	
	public function fetchNewClient()
	{
		$clientId=Client::get_all_clientid() ;
		$Corporation=Corporation::find()->asArray()->indexBy('id')->all();
		$fetchCorporation=$Corporation;
        $allClientArray=[];
		$fetchCorporationArray=[];
       
        foreach($clientId as $clienIdKey=>$clienIdValue){
         	array_push($allClientArray,$clienIdValue['corporation_id']);
		}
		
		foreach($fetchCorporation as $CorporationKey=>$CorporationValue){
  			array_push($fetchCorporationArray,$CorporationValue['id']);
		}
		
		$newClient=array_diff($fetchCorporationArray,$allClientArray);
		$client=Corporation::findAll(array_values($newClient));
		return $client;
	}
	
	
	public function fetchNewSupplier()
	{
		$supplierId=Supplier::get_all_supplierid();
		$Corporation=Corporation::find()->asArray()->indexBy('id')->all();
		$fetchCorporation=$Corporation;
        $allSupplierArray=[];
		$fetchCorporationArray=[];
       
        foreach($supplierId as $supplierIdKey=>$supplierIdValue){
         	array_push($allSupplierArray,$supplierIdValue['corporation_id']);
		}
		
		foreach($fetchCorporation as $CorporationKey=>$CorporationValue){
  			array_push($fetchCorporationArray,$CorporationValue['id']);
		}
		
		$newSupplier=array_diff($fetchCorporationArray,$allSupplierArray);
		$supplier=Corporation::findAll(array_values($newSupplier));
		return $supplier;
	}
	
	//Added by Anthony
	
	public function getShortName() 
	{
		return $this->short_name;
	}
	
	public function getNameString() 
	{
		return $this->name . " (" . $this->short_name . ")";
	}
	
	public static function displayAllCorporation()
	{
		$allCorporation = self::find()
    		->asArray()
    		->all();
        return $allCorporation;
	}
}
