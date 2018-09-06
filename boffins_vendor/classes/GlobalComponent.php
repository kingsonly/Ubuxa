<?php 

namespace boffins_vendor\classes;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use common\models\AccessPermission;


/******************

A component registered to the app. 
You can use this component to manage random functions that are needed globally. 
Or variables you want to store and manipulate globally. 
Please note that Yii::$app->params is an array already available for use for storing app state and settings. 


******************/ 
class GlobalComponent extends Component
{
	/***
	 * an array of Nothing Quotes
	 * in the future, considering making this private and use getters and setters to manage. 
	 */ 
	public $smartNothingQuotes = array( 
									'Nothing ventured, nothing gained',
									'Nothing in life is for free',
									'Laziness is nothing but the habit of resting before you get tired',
									'Success is nothing more than a few simple disciplines, practiced every day',
									'I see nothing. I hear nothing. I taste nothing. I smell nothing. I touch nothing. I am nothing?',
									'Anything positive is better than nothing',
									'I expect nothing, but I deliver everything',
									'Saying nothing sometimes says the most',
									);
	/***
	 * returns a random quote from the array of quotes. 
	 * @return string
	 */ 
	public function getMeNothingQuote() 
	{
		$max = count($this->smartNothingQuotes) - 1;
		return $this->smartNothingQuotes[mt_rand(0, $max)];
	}
	
	/**
	 * returns the value from AccessPermission model's static function of the same name. 
	 * @return boolean
	 */
	public function containsPermission($accessLevel, $permision, $allPermissions = []) 
	{
		return AccessPermission::containsPermission($accessLevel, $permision, $allPermissions = []);
	}
	
}