<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\models\{ValueARModel, ValueInterface, Sortable, KnownClass};

/**
 * This is the model class for table "{{%value_known_class}}".
 *
 * @property int $id
 * @property string $value full class name including namespace of the class
 * @property string $query query to be applied against the class to get the instance needed
 */
class ValueKnownClass extends ValueARModel implements ValueInterface, Sortable
{
	const KNOWN_CLASS_INTERFACE_NAME = 'boffins_vendor\classes\models\KnownClass';
	
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
            [['value', 'query'], 'safe'],
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
		if ( empty($this->getValue()) ) {
			Yii::warning("This value is empty");
			return '';
		}
		if ( $this->getValue() instanceof KnownClass ) {//$this->_usefulValue is defined in parent class.
			return $this->_usefulValue->nameString;
		}
		Yii::warning("This value type works with objects that are truly 'known classes'. Implement the interface KnownClass on the object");
		return json_encode($this->_usefulValue) ;
	}
	
	/***
	 *  @brief Required. FUNCTION NOT IMPLEMENTED. 
	 */
	public function formattedStringValue($externalFormat = '', $paramsToInject = []) : string
	{
		Yii::warning("Sorry, formattedStringValue is not implemented in ValueKnownClass!" . __METHOD__ );
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
		if (!empty($_usefulValue)) { //if this get has not been invoked.
			return $this->_usefulValue;	
		}
		
		$knownNameSpace = $this->value;
		$valueObject = null;
		
		if ( ! class_exists($knownNameSpace) ) {
			Yii::error("The value stored is not a class " . (string)$knownNameSpace );
			return null;
		}
		
		if ( ! in_array( SELF::KNOWN_CLASS_INTERFACE_NAME, class_implements($knownNameSpace) ) )  {
			Yii::error("The value stored is not a known class");
			return null;
		}
		
		if (!$this->isNewRecord && !empty($this->query)) {
			
			Yii::trace("The known name space of this value is {$knownNameSpace} " . __METHOD__ );
			try {
				$valueObject = $knownNameSpace::find()->where($this->query)->one();
			} catch(Exception $e) {
				Yii::warning("An exception occured! " . $e->getMessage() . __METHOD__ . "\n" );
			}
		}
		
		$this->_usefulValue = empty($valueObject) ? null : $valueObject;
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
		Yii::trace("Setting the value in vkc");
		if (empty($value) || !is_array($value)) {
			$errorVal = empty($value) ? 'NULL' : gettype($value);
			Yii::warning("Setting an unnaceptable value. Must be an array. {$errorVal} was given. Setting to null.");
			$this->_usefulValue = null;
		} else {
			if ( !array_key_exists('nameSpace', $value) && !array_key_exists('condition', $value) ) {
				Yii::warning("To ammend a ValueKnownClass, please provide a condition and/or a new knownclass namespace");
				return;
			}
			Yii::trace("Array Keys exist");
			if ( ! empty($value['nameSpace']) ) {
				$nameSpace = $value['nameSpace'];
				if ( ! class_exists($nameSpace) ) {
					Yii::warning("You cannot set this namespace as it is not a valid class. " . (string)$nameSpace );
				} elseif ( ! in_array( SELF::KNOWN_CLASS_INTERFACE_NAME, class_implements($nameSpace) ) )  {
					Yii::warning("You cannot set this namespace as it is not a valid KnownClass. " . (string)$nameSpace );
				} else {
					Yii::trace("Is this actually setting namespace");
					$this->setAttribute('value', $value['nameSpace']);
				}
			}
			
			if ( ! empty($value['condition']) ) {
				if ( !is_string($value['condition']) ) {
					Yii::error("You cannot set this condition as it is not a string.");
				} elseif ( strpos($value['condition'], "=") !== false && strpos($value['condition'], "=") > 0 ) {
					//only passes if = is in the string AND it is in position 1 or more (there should be something on
					//the left side of the condition)
					Yii::trace("Is this actually setting condition");
					$this->setAttribute('query', $value['condition']);
				} else {
					Yii::warning("Please double check your condition string as it does not pass basic validation: {$value['condition']}");
				}
			}
		}
		Yii::trace("New Values {$this->value} and {$this->query} ");
	}
	
	
	protected function resetValue()
	{
		$this->getValue();
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
