<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
use frontend\models\Folder;
use frontend\models\ComponentTemplate;

?>


<?php 

/** this widget is responsible for dispaying the button which is used to create a new Folder,
** This display can either be an image or a plane text
****************************** Basic Usage 
* echo CreateButtonWidget::widget();
* 3 public properties 
* buttonType the widget is design in such a way that a user can chose button type, default is folder image for 
* creating a  new folder, other options include as an icon or text with icon.
* htmlAttributes is an array which holds all html attributes associated to this widget eg class, id, style etc
* iconJs is a uniqe property, which actually holds the javascript action of the icon whenclicked
********************/

class CreateButtonWidget extends Widget{
	
	public $buttonType ;// types coulde be icon,text,orimage
	public $htmlAttributes ;// including style,class,idetc
	public $iconJs ;// javascript action for icon type click event 
	
	public function init()
	{
		parent::init();
	}
	
	// output the outcome of loopmenu
	public function run()
	{
		$componentTemplate = $this->getComponentTemplate();
		return $this->render('createbuttonview',[
			'buttonType' => $this->buttonType,
			'class' => $this->buttonType,
			'htmlAttributes' => $this->htmlAttributes,
			'iconJs' => $this->iconJs,
			'componentTemplate' => $componentTemplate,
		]);
	}
	// fetch all company and default atrribute 
	private function getComponentTemplate()
	{
		return  ComponentTemplate::find()->andWhere(['cid'=>0])->orWhere(['cid' =>yii::$app->user->identity->cid])->all();
	}
	
}


?>
