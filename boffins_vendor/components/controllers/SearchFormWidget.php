<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
use frontend\models\Folder;

?>


<?php 

/**
** This widget holds an input which can be used to search for sub-folders in the folder dashboard 
****/

class SearchFormWidget extends Widget{
	
	public $filterContainer;
	public function init()
	{
		parent::init();
	}
	
	public function run(){
		
		return $this->render('searchform',[
			'filterContainer' => $this->filterContainer,
		]);
	}
	
}


?>
