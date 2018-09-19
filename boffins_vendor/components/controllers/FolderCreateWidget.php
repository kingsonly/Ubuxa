<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
use frontend\models\Folder;

?>


<?php 



class FolderCreateWidget extends Widget{
	
	public function init()
	{
		parent::init();
	}
	private $folderModel;
	// output the outcome of loopmenu
	public function run(){
		$this->folderModel = new Folder();
		return $this->render('foldercreatewidgetview',[
			'folderModel' => $this->folderModel,
		]);
	}
	
}


?>
