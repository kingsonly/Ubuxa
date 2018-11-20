<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
?>


<?php 



class ViewWithXeditableWidget extends Widget{
	public $model;
	public $imageUrlOutput;
	public $imageDisplayUrl;
	public $xEditableDateId;
	public $editableArea;
	
	public $attributues = [];

	public function init()
	{
		parent::init();
	}
	
	// output the outcome of loopmenu
	public function run(){
		if(empty($this->imageDisplayUrl)){
			$this->imageDisplayUrl = 'images/company/folder_image/image_placeholder.png';
		} 
		return $this->render('viewwithxeditablewidgetview',[
			'model' => $this->model,
			'attributues' => $this->attributues,
			'imageUrl' => $this->imageUrlOutput,
			'displayImage' => $this->imageDisplayUrl,
			'xEditableDateId' => $this->xEditableDateId,
			'editableArea' => $this->editableArea,
		]);
	}
	
}


?>