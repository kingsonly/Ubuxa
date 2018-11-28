<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\models\{ValueARModel, ValueInterface, Sortable};


/**
 * This is the model class for table "{{%value_long_string}}".
 * 
 * "{{%value_long_string}}" is to store long strings like blog article text, long descriptions, wiki content etc.
 * "{{%value_long_string}}" should ideally be for unformatted, unformattable string. "{{%value_code_string}}" could 
 * be used to capture html strings or other code strings that have formatting. 
 *
 * @property int $id preferred table for long strings as it has an index for searching
 * @property string $value
 */
class ValueLongString extends ValueARModel implements ValueInterface, Sortable
{
    
	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%value_long_string}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string'],
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
	 *  @return String. Unformatted string of the core value i.e. 'value'
	 *  use formattedStringValue() for a formatted version. 
	 */
	public function stringValue() : string
	{
		return $this->getValue();
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
	 *  
	 *  formattedStringValue is not ideal for ValueLongString as there are limits to how a simple string may be formatted???
	 *  this function is more for other Value types such as ValueCodeString. 
	 */
	public function formattedStringValue($externalFormat = '', $paramsToInject = []) : string
	{
		Yii::warning("Requesting a formatted string value on an unformattable Value Type. Try ValueCodeString instead." . __METHOD__ );
		return $this->getValue();
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
			$this->_usefulValue = $this->value;
		}
		
		return $this->_usefulValue;
	}
	
	/***
	 *  @brief setter for value property
	 *  
	 *  @return no return value. This is a setter 
	 *  
	 *  @details if the $value provided by the user is empty, sets _usefulValue to null 
	 */
	public function setValue($value)
	{
		if ( $value === null || !is_scalar($value) ) {
			$errVal = $value === null ? 'NULL' : gettype($value);
			Yii::warning("Setting an unnaceptable value. Must be a string, {$errVal} given. Setting to null.");
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
		return substr($this->value, 1, 10);
	}
	
	/**
	 *  @brief A function to provide information about the stored value.
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
			'data_info' => 'STRING: ' . strlen($this->value),
			'value' => $this->value,
		];
	}
	
}
