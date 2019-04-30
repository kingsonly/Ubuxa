<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\models\{ValueARModel, ValueInterface};

/**
 * This is the model class for table "{{%value_boolean}}".
 *
 * @property int $id
 * @property int $value To store boolean values.
 */
class ValueBoolean extends ValueARModel implements ValueInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%value_boolean}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('component', 'ID'),
            'value' => Yii::t('component', 'Value'),
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
	 *  @param [in] Optional. $changeDefaultValues a valid format in which you want the string returned 
	 *  @param [in] Optional. $newTrueFalseValues parameters to inject into a  the string to modify it. 
	 *  @return string. The formatted String
	 *  
	 *  @details If $changeDefaultValues is not exactly true, then this should immediately 
	 *  return the getValue() function to return the stringValue() which are the defaults. 
	 */
	public function formattedStringValue($changeDefaultValues = false, $newTrueFalseValues = []) : string
	{
		if ( $changeDefaultValues === true && is_array($newTrueFalseValues) ) {
			if ( $this->value && array_key_exists('value_true', $newTrueFalseValues) ) {
				return $newTrueFalseValues['value_true'];
			} 
			
			if ( !$this->value && array_key_exists('value_false', $newTrueFalseValues) ) {
				return $newTrueFalseValues['value_false'];
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
		if (!is_bool($value) && $value != 1 && $value !=0 ) {
			Yii::warning("Setting an unnaceptable value. Must be boolean. {$value} was given. Setting to null.");
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
			'data_info' => 'BOOLEAN: ' . strlen($this->value),
			'value' => $this->value,
		];
	}
}
