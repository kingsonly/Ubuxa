<?php
namespace app\boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
?>


<?php 

/** 
* Menu widget which is aimed at reusing a single line of code to populate the entire menu of tycol main
* Total properties 6
* Total public properties 2 which are $icon and $componentMenuSetting
* Total private properties 4 which are $defaultIcon,$privateIcon,$defaultComponentMenu,$componentMenu
* Total methods 3
* Total public method 2 which are init and run
* Total private method 1 which is loopMenu
* 1 view file 
* usage 
* on view file ensue to load the class as such 
* use app\components\controllers\Menu
* <?=Menu::widget(['icon'=>['menu1'=>'icon1','menu2'=>'icon2'],'componentMenuSetting'=>['menu1','menu2']]); ?>
*/

class Menu extends Widget{
	/* 
	* menu icon which could be used to add more icone , note key should be same as menu name eg 
	* ['menu name' =>'css fa icon name ']
	*/
	public $icon;  
	
	/* 
	* menu defaulticon an array off all presently avalable menu icon
	*/
	private $defaultIcon = [
			'folder'=>'fa-folder',
			'project'=>'fa-briefcase',
			'invoice'=>'fa-print',
			'order'=>'fa-first-order',
			'payment'=>'fa-credit-card-alt',
			'receivedpurchaseorder'=>'fa-quote-left',
			'correspondence'=>'fa-quote-left'];
	
	/* 
	* menu $privateIcon an array off all icons merged in the init method
	*/
	
	private $privateIcon;
	
	public $componentMenuSetting;// used to add more menu to the list of menu
	
	// defaultComponentMenu is an array of all presently available menu by default
	private $defaultComponentMenu =[
			'folder',
			'project',
			'invoice',
			'order',
			'payment',
			'receivedpurchaseorder',
			'correspondence'
		];
	
	private $componentMenu;// a merger of custom and default menu
	
	// init of properties 
	public function init()
	{
		parent::init();
		
		if(empty($this->componentMenuSetting)){
			$this->componentMenu = $this->defaultComponentMenu;
		} else {
			$this->componentMenu = array_merge($this->defaultComponentMenu,$this->componentMenuSetting);
		}
		
		if(empty($this->icon)){
			$this->privateIcon = $this->defaultIcon;
		} else {
			$this->privateIcon = array_merge($this->defaultIcon,$this->icon);
		}
	}
	
	// output the outcome of loopmenu
	public function run(){
		return $this->loopMenu();
	}
	
	// entire menu logic is done in this method which loads the view file and pass the nessesary data
	private function loopMenu(){
		
		return $this->render('index',[
			'componentMenu' => $this->componentMenu,
			'icons' => $this->privateIcon,
		]);
  	
	}
}


?>