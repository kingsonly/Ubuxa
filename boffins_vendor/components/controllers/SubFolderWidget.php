<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
use frontend\models\Folder;

?>


<?php 



class SubFolderWidget extends Widget{
	public $model;
	public function init()
	{
		parent::init();
	}
	
	// output the outcome of loopmenu
	public function run(){
		return $this->render('subfolderwidgetview',[
			'model' => $this->model,
		]);
	}
	
}


?>
