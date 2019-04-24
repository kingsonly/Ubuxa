<?php

/**
 * @copyright Copyright (c) 2019 Ubuxa (By Epsolun Ltd)
 * @author Anthony Okechukwu
 */

namespace boffins_vendor\classes;

use Yii;

trait MessageConstructTrait 
{
    /**
	 * an array of sentence consturcts.
	 */
	protected $_sentenceConstruct = [];
		
	/***
	 * provides a format in which a message node may be resolved into a phrase
	 */
	protected $sentenceFormat = '{verb} {article} {object}';
	
	/**
	 * @brief Adds a construct and value in order to build a phrase. 
	 *  
	 * @param [string] $key the sentence construct
	 * @param [mixed  string|callable|MessageConstructInterface] $value the value to set for the sentence construct
	 * @return void
     * 
     * @details if the $value is to be calculated, either provide a closure (lamda function) which returns a string. 
     * The function must have the following signature function() : string {}
     * Or  provide an array with the first item being an object, and the second item a function within that 
     * object's class which returns a string.
	 */
	public function addConstruct($key, $value)
	{
		if (! is_string($key) ) {
			throw new yii\base\InvalidArgumentException("Sentence constructs must be a string");
        }
        
        if ( ! ( is_string($value) || is_callable($value) || $value instanceof MessageConstructInterface ) ) {
            throw new yii\base\InvalidArgumentException("String, Callable or MessageConstructInterface required!");
        }

		$this->_sentenceConstruct[$key] = $value;
	}
    
    /***
     * @brief resolves a message construct into a sentence/phrase by replacing constructs with their intended values
     * 
     */
	public function resolve()
	{
		if (empty($this->_sentenceConstruct)) {
			Yii::warning("You have not provided any constructs.", __METHOD__ );
			return '';
        }
        
		$matchCount = 0; //not the way to go 
		$result = $this->sentenceFormat;
		$missingConstructs = [];
		foreach ($this->_sentenceConstruct as $construct => $value) {

            if ( $value instanceof MessageConstructInterface  ) {
                $result = str_replace("{" . $construct . "}", $value->resolve(), $result, $matchCount);
            }

            if ($value instanceof Closure || (is_array($value) && is_callable($value))) {
                $calculatedValue = call_user_func($value);
                $result = str_replace("{" . $construct . "}", $calculatedValue, $result, $matchCount);
            }
    
            if ( is_string($value) ) {
                $result = str_replace("{" . $construct . "}", $value, $result, $matchCount);
            } 
			
			//Yii::warning("{$construct} and $value val and result $result $matchCount and $result", __METHOD__);
			if (!$matchCount) {
				$missingConstructs[$construct] = $value;
			}
        }
        
		if (!empty($missingConstructs)) {
			//do action when it is less and when it is more. 
		}
		return $result;
		//if a any constructs specified in the format do not exist in the construct then ignore them. 
    }

    /***
     * @brief a funcion that prepends a format to the sentenceFormat. 
     * @param [str] $format the format to add.
     */
    public function prependFormat($format) 
    {
        $this->sentenceFormat = '{' . $format . '} ' . $this->sentenceFormat; 
    }

    /***
     * @brief a funcion that appends a format to the sentenceFormat. 
     * @param [str] $format the format to add.
     */
    public function appendFormat($format) 
    {
        $this->sentenceFormat = $this->sentenceFormat . ' {' . $format . '}'; 
    }
}
?> 