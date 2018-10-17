<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
use frontend\models\Folder;

?>


<?php 

/** this widget is responsible for dispaying the button which is used to create a new Folder,
** This display can either be an image or a plane text
***************************/

class CreateButtonWidget extends Widget{
	
	public function init()
	{
		parent::init();
	}
	public $buttonType ;
	public $htmlAttributes ;
	
	// output the outcome of loopmenu
	public function run(){
		
		return $this->render('createbuttonview',[
			'buttonType' => $this->buttonType,
			'class' => $this->buttonType,
			'htmlAttributes' => $this->htmlAttributes,
		]);
	}
	
}


?>
