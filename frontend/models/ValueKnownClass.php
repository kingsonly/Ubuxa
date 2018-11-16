<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\models\{ValueARModel, ValueInterface, Sortable};

/**
 * This is the model class for table "{{%value_known_class}}".
 *
 * @property int $id
 * @property string $value full class name including namespace of the class
 * @property string $query query to be applied against the class to get the instance needed
 */
class ValueKnownClass extends ValueARModel implements ValueInterface, Sortable
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%value_known_class}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'query'], 'string', 'max' => 255],
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
            'query' => Yii::t('component', 'Query String'),
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
	 */
	public function formattedStringValue($externalFormat = '', $paramsToInject = []) : string
	{
		if ( empty($format) || !is_array($format) || !array_key_exists('separator', $format) ) {
			Yii::warning("Requesting a formatted string value but no format provided or format not an array, or has no separator" . __METHOD__ );
			return $this->stringValue();
		}
		
		return number_format($this->value, NULL, NULL, $format['separator'] );
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
		if (!empty($_usefulValue)) { //if this get has not been invoked.
			return $this->_usefulValue;	
		}
		
		if (!$this->isNewRecord && !empty($this->query)) {
			$knownNameSpace = $this->value;
			try {
				Yii::warning("Value - {$knownNameSpace}");
				$valueObject = $knownNameSpace::find([$this->query])->asArray();;
			} catch(Exception $e) {
				Yii::warning("An exception occured! " . $e->getMessage() . "\n" );
			}
		}
		$this->_usefulValue = $valueObject;
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
		if (empty($value) || !is_array($value)) {
			$errorVal = empty($value) ? 'NULL' : $value;
			Yii::warning("Setting an unnaceptable value. Must be an array. {$errorVal} was given. Setting to null.");
			$this->_usefulValue = null;
		} else {
			//to be implemented later 
			Yii::warning('Set Value for Known Class needs to be fully implemented');
			//$this->_usefulValue = $value;
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
		throw new Exception("Sort field not yet implemented");
		return NULL;
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
			'data_info' => "{$this->value}: {$this->query}" ,
			'value' => $this->getValue(),
		];
	}
}
