<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\models\KnownClass;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property integer $id
 * @property string $country 
 * @property string $currency_code
 * @property string $currency_title 
 * @property string $symbol
 * @property string $unit_text
 * @property string $subunit_text
 *
 */
class Currency extends \yii\db\ActiveRecord implements KnownClass
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%currency}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency_code'], 'required'],
            [['currency_code'], 'string', 'max' => 4],
			[['country', 'currency_code', 'currency_title'], 'required'],
		    [['country', 'currency_title'], 'string', 'max' => 255],
		    [['currency_code'], 'string', 'max' => 5],
            [['symbol'], 'string', 'max' => 1],
            [['unit_text', 'subunit_text'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
			'country' => 'Country', 
            'currency_code' => 'Currency Code',
			'currency_title' => 'Currency Title', 
            'symbol' => 'Symbol',
            'unit_text' => 'Unit Text',
            'subunit_text' => 'Subunit Text',
        ];
    }
	/**
	 *  @brief returns a string which acts as an identifier for the currency. 
	 *  
	 *  @return string 
	 */
	public function getcurrencyString() 
	{
		return $this->country . " (" . $this->currency_code . ") - " . $this->symbol;
	}
	
	/**
	 *  @brief returns a string which acts as an identifier for the currency. 
	 *  
	 *  @return string 
	 *  
	 *  @details implementation needed for KnownClass interface. 
	 */
	public function getNameString() : string
	{
		return $this->getCurrencyString();
	}
}
