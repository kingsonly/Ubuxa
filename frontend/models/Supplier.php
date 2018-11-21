<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\BoffinsArRootModel;
use boffins_vendor\classes\models\{TenantSpecific, TrackDeleteUpdateInterface};

/**
 * This is the model class for table "{{%supplier}}".
 *
 * @property integer $id
 * @property integer $corporation_id
 * @property string $supplier_type
 * @property string $notes
 *
 * @property Project[] $Projects
 * @property Corporation[] $Corporation

 */
class Supplier extends BoffinsArRootModel implements TenantSpecific, TrackDeleteUpdateInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%supplier}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['corporation_id'], 'required'],
            [['corporation_id'], 'integer'],
            [['supplier_type', 'notes'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
		
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'corporation_id' => 'Corporation ID',
            'supplier_type' => 'Supplier Type',
            'notes' => 'Notes',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['supplier_id' => 'id']);
    }
    
    /**
     * CHANGES BY BOFFINS
     */
	 
	//Added by Kingsley 
    public static function get_all_supplierid()
	{
        $suppliers = Supplier::find()->asArray()->indexBy('id')->all();        
        return $suppliers;
    }
	
	//Added by Anthony
	
	public function getCorporation() 
	{
		return $this->hasOne(Corporation::className(), ['id' => 'corporation_id'] );
	}
	
	public function getName() 
	{
		return $this->corporation->name;
	}
	
	public function getShortName() 
	{
		return $this->corporation->shortName;
	}
	
	public function getNameString() 
	{
		return $this->corporation->NameString;
	}
	
	
}
