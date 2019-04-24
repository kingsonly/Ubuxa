<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\models\{ValueARModel, ValueInterface};

/**
 * This is the model class for table "tm_value_timestamp".
 *
 * @property int $id
 * @property string $value the actual value of the cell
 */
class ValueTimestamp extends ValueARModel implements ValueInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_value_timestamp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
        ];
    }
	/***
	 *  @brief Required. See Interface ValueInterface
	 *  
	 *  @return String. Returns a user friendly string from component messages default. 
	 *  
	 *  If you want to return different values for true and false, you need to use formattedStringValue() method and provide 
	 *  the values you want. 
	 */
	public function stringValue() : string
	{
		return $this->getValue() ? Yii::t('component', 'value_true' ) : Yii::t('component', 'value_false');
	}
	
	/***
	 *  @brief Required. See Interface ValueInterface.
	 *  
	 *  @param [in] Optional. $externalFormat a valid format in which you want the string returned 
	 *  @param [in] Optional. $paramsToInject parameters to inject into a  the string to modify it. 
	 *  @return string. The formatted String
	 *  
	 *  @details If $format is not provided, then this should immediately return the getValue() function to return the 
	 *  unformatted string. 
	 */
	public function formattedStringValue($changeDefaultValues = false, $paramsToInject = []) : string
	{
		if ( $externalFormat === true && is_array($paramsToInject) ) {
			if ( $this->value && array_key_exists('value_true', $paramsToInject) ) {
				return $paramsToInject['value_true'];
			} 
			
			if ( !$this->value && array_key_exists('value_false', $paramsToInject) ) {
				return $paramsToInject['value_false'];
			} 
		}
		return $this->stringValue();
	}
	
	/***
	 *  @brief getter for value property. 
	 *  
	 *  @return Thee value property that this model is designed to hold 
	 *  
	 *  @details uses the private $_usefulValue which is just a simulacrum of the value this model holds 
	 */
	public function getValue() 
	{
		if (empty($_usefulValue)) { //if this get has not been invoked.
			$this->_usefulValue = $this->value ? true: false;
		}
		
		return $this->_usefulValue;
	}
	
	/***
	 *  @brief setter for value property
	 *  
	 *  @return no return value. This is a setter 
	 *  
	 *  @details if the $value provided by the user is empty or not an integer, sets _usefulValue to null 
	 */
	public function setValue($value)
	{
		if (empty($value) || !is_integer($value) ) {
			Yii::warning("Setting an unnaceptable value. Must be intege. {$value} was given. Setting to null.");
			$this->_usefulValue = null;
		} else {
			$this->_usefulValue = $value;
			$this->setAttribute('value', $value);
		}
	}
	
	/***
	 *  @brief returns a value/field on which the class instance can be compared against another.
	 *  use the first 10 characters of the string to sort (highly unlikely you will encounter sorting scenarios in whihc
	 *  mmre then the first 10 characters are identical)
	 *  @return the sort field/value 
	 */
	public function getSortField()
	{
		return $this->value;
	}
	
	/**
	 *  @brief A function to provide information about the store value.
	 *  
	 *  @return an array with two $key => $value pairs: the value and 
	 *  'data_info' which indicates what kind of data being stored. 
	 *  data info should be in the structure of 'data_type: some additional info'
	 *  
	 *  @details for Value Types that store literals, this is trivial as the value is a 
	 *  traditional data type already indicated by the class name
	 *  but for value types that stores objects, it can provide critical information about 
	 *  what kind of object stored by the value. 
	 */
	public function metaValue()
	{
		return [
			'data_info' => 'INTEGER: ' . strlen($this->value),
			'value' => $this->value,
		];
	}
}
