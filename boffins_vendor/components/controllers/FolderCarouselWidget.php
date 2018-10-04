<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
use frontend\models\Folder;

?>


<?php 



class FolderCarouselWidget extends Widget{
	
	public function init()
	{
		parent::init();
	}
	public $folderModel;
	// output the outcome of loopmenu
	public function run(){
		
		return $this->render('foldercarouselwidgetview',[
			'folderModel' => $this->folderModel,
			
		]);
	}
	
	

	
}


?>
