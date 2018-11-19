<?php

namespace frontend\settings\components;

use Yii;
use yii\base\Component;
use yii\helpers\Url;
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
		$companySettings = $model->find()->where(['cid' => !empty(\Yii::$app->user->identity->cid)?\Yii::$app->user->identity->cid:0 ])->one();
		return $companySettings;
	}
	
	/* companyDate private method of the settings component
	 * ----- Function Responsibility --------
	 * THis method comunicate with the companySettings method 
	 * Checks the database value of all date and time stamp column and converts depending on the column fomart
	 * takes a single argument $dateTime wich is determine by the date behavior 
	 */
	private function companyDate($dateTime)
	{
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
	 * Method boffinsDate would be use to set the output of all date as set by the customer
	 * presently takes two argument $dateValue and $dateType
	 * $dateValue = to the actual date passed to the method eg 10/10/17
	 * $dateType is used to check the database column type so as to decide how to handle the date pased
	 * $ this method id going to take advantage of the yii2 data formatter for date to make relevant converssions
	 * 
	 */
	public function boffinsDate($dateValue , $dateType)
	{
		
		\Yii::$app->formatter->{$dateType."Format"} = $this->companyDate($dateType);
		$actualDate = \Yii::$app->formatter->{'as'.ucfirst($dateType)}($dateValue);
	
		return $actualDate ? $actualDate : 'something went wrong '; //this really should be a timestamp of NOW()
							
	}
	
	/*
	 * Method boffinsLogo would be use to set the output logo as set by the customer
	 * presently takes no argument 
	 * makes use of the companySettings() private method to fetch the company define logo 
	 * checks to see if the logo is a string or an image and displays according to data type on the layout 
	 * 
	 */
	public function boffinsLogo()
	{
		$companySettings = $this->companySettings();
		$logoSettings = $companySettings->logo;
		$supported_image = ['gif', 'jpg','jpeg','png'];

		$ext = strtolower(pathinfo($logoSettings, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
		/*
		 * if content is an image use image tage else formart as string
		 */
		if (in_array($ext, $supported_image)) {
			return '<img  style="height: 45px;width: 160px;margin:3px 5px 3px 25px" src="'.Url::to("@web/".$logoSettings).'" />';
			
		} else {
			return $logoSettings;
		}
	}
	
	public function boffinsLoaderImage()
	{
		return '<img  style="height: 40px;width: 40px;margin:3px 5px 3px 25px" src="'.Url::to("@web/images/loader/loader.gif").'" />';
	} 
	
	public function boffinsDefaultLogo()
	{
		return 'images/6uCHTvn3GkT_UYxbI4Fl8DklnwGQw00N.png';
	} 
	
	public function boffinsDefaultLanguage()
	{
		return 'En';
	} 
	
	public function boffinsDefaultTemplate()
	{
		return 'StandardFormsAsset';
	} 
	
	public function boffinsDefaultDateFormart()
	{
		return 'MMMM d  yyyy ! (HH:mm:ss)';
	} 
	
	/*
	 * Method boffinsUsersAsset would be use to set the theme as set by the customer
	 * presently takes no argument 
	 * makes use of the companySettings() private method to fetch the company define theme  
	 * 
	 */
	public function boffinsUsersAsset()
	{
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
	 * Method boffinsUsersLanguage would be use to set the language as set by the customer
	 * presently takes no argument 
	 * makes use of the companySettings() private method to fetch the company define theme  
	 * 
	 */
	public function boffinsUsersLanguage()
	{
		$companySettings = $this->companySettings();
		$languageSettings = $companySettings->language;
		
		return $languageSettings;
	}
	
	
}
