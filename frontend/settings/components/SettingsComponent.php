<?php

namespace frontend\settings\components;

use Yii;
use yii\base\Component;
use frontend\settings\models\Settings;




/**
 * Class Settings
 *
 * @package yii2mod\settings\components
 */
class SettingsComponent extends Component
{
	
	/* companySettings private method of the settings component
	 * ----- Function Responsibility --------
	 * THis method comunicate with the database to get the users company id 
	 * Using the company id to select company specific config such as date, logo, language, etc
	 *
	 */
	private function companySettings()
	{
		$model = new Settings();
		$companySettings = $model->find()->where(['id' => !empty(\Yii::$app->user->identity->id)?\Yii::$app->user->identity->id:0 ])->one();
		return $companySettings;
	}
	
	/* companyDate private method of the settings component
	 * ----- Function Responsibility --------
	 * THis method comunicate with the companySettings method 
	 * Checks the database value of all date and time stamp column and converts depending on the column fomart
	 * takes a single argument $dateTime wich is determine by the date behavior 
	 */
	private function companyDate($dateTime){
		$companyDateFormart = $this->companySettings();
		if(!empty($companyDateFormart->date_format)){
			$seperateDateFromTime = explode('!',$companyDateFormart->date_format);
			if($dateTime == 'datetime'){
				if(!empty($companyDateFormart->date_format) and count($seperateDateFromTime) > 1){
					$dateStrin = $seperateDateFromTime[0].'  '. $seperateDateFromTime[1] .' ';
				}
			} else{
				$dateStrin = !empty($companyDateFormart->date_format)?$seperateDateFromTime[0]:'full'; 
			}
		} else {
			$dateStrin = 'full';
		}
		
		 
		return $dateStrin;
	}
	
	/*
	 * Method buffinsDate would be use to set the output of all date as set by the customer
	 * presently takes two argument $dateValue and $dateType
	 * $dateValue = to the actual date passed to the method eg 10/10/17
	 * $dateType is used to check the database column type so as to decide how to handle the date pased
	 * $ this method id going to take advantage of the yii2 data formatter for date to make relevant converssions
	 * 
	 */
	public function buffinsDate($dateValue , $dateType){
		
		\Yii::$app->formatter->{$dateType."Format"} = $this->companyDate($dateType);
		$actualDate = \Yii::$app->formatter->{'as'.ucfirst($dateType)}($dateValue);
	
		return $actualDate ? $actualDate : 'something went wrong '; //this really should be a timestamp of NOW()
							
	}
	
	/*
	 * Method buffinsLogo would be use to set the output logo as set by the customer
	 * presently takes no argument 
	 * makes use of the companySettings() private method to fetch the company define logo 
	 * checks to see if the logo is a string or an image and displays according to data type on the layout 
	 * 
	 */
	public function buffinsLogo(){
		$companySettings = $this->companySettings();
		$logoSettings = $companySettings->logo;
		$supported_image = ['gif', 'jpg','jpeg','png'];

		$ext = strtolower(pathinfo($logoSettings, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
		/*
		 * if content is an image use image tage else formart as string
		 */
		if (in_array($ext, $supported_image)) {
			return '<img  style="height: 50px;width: 50px;margin:3px 5px 3px 25px" src="'.$logoSettings.'" />';
		} else {
			return $logoSettings;
		}
	}
	
	/*
	 * Method buffinsUsersAsset would be use to set the theme as set by the customer
	 * presently takes no argument 
	 * makes use of the companySettings() private method to fetch the company define theme  
	 * 
	 */
	public function buffinsUsersAsset(){
		$companySettings = $this->companySettings();
		$themeSettings = $companySettings->theme;
		if(\Yii::$app->controller->id == 'site' and \Yii::$app->controller->action->id == 'index' ){
			$themeAssetNameSpace  = '\\app\\assets\\IndexDashboardAsset';
		} else{
			$themeAssetNameSpace  = '\\app\\assets\\'.$themeSettings;
		}
		
		return $themeAssetNameSpace::register(\Yii::$app->view);
	}
	
	/*
	 * Method buffinsUsersLanguage would be use to set the language as set by the customer
	 * presently takes no argument 
	 * makes use of the companySettings() private method to fetch the company define theme  
	 * 
	 */
	public function buffinsUsersLanguage(){
		$companySettings = $this->companySettings();
		$languageSettings = $companySettings->language;
		
		return $languageSettings;
	}
	
	
}
