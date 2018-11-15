<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
use frontend\models\Folder;

?>


<?php 


// this widget is presently not relevant as such  the name should be changed to folder display widget
// this widget helps to display folder on the folder index page and on the dashboard 
class SubFolderWidget extends Widget{
	public $model;
	public $creationModel;
	public function init()
	{
		parent::init();
	}
	
	
	public function run(){
		return $this->render('subfolderwidgetview',[
			'model' => $this->model,
			'creationModel' => $this->creationModel,
		]);
	}
	
}


?>
