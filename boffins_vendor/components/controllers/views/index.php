<?php
use app\models\Folder;

use yii\widgets\Pjax;
use app\controllers\ProjectController as project;
use yii\helpers\Html;
use app\models\Person;
use  yii\bootstrap\Modal;
use yii\helpers\Url;


/* @var $this yii\web\View */


//$this->title = 'My Yii Application';
?>

<?php 

foreach($componentMenu as $k => $v){
			$url = $v.'/index' ;
			echo Html::tag('li',Html::a(Html::tag('i', '', ['class' => 'fa '.$icons[$v],'title' => $v]). Html::tag('span', ucfirst($v), ['class' => '','title' => $v]), [$url]
		, ['class' => '','title' => 'Open'.$v,]),['class' => ( Yii::$app->controller->id == $v) ? 'active' : 'false'] );
			
		}
?>