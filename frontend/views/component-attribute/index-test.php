<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('component', 'Just a space to test ModelCollection! Please ignore');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="component-attribute-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('component', 'Create Component Attribute'), ['create'], ['class' => 'btn btn-success']) ?>
    
	<p>
	<? $count = count($models); ?>
	
	<?= "Count: {$count} \n UsesQuery: {$usesQuery} </br> " ?>
	<?php $i=0; foreach($models as $model) {
		echo "({Name: {$model['id']} \n"; 
		echo "Value: {$model['title']} \n"; 
		echo "This Model: {$models[$i]['title']} )} </br>"; 
		//var_dump($model->getComponentAttribute()[0]['value']);
		foreach($model->getComponentAttribute() as $key => $componentDetails){
			echo $componentDetails['value'].'<br>';
			echo'<pre>';
			var_dump($componentDetails);
			echo'</pre>';
			
		}
	
		$i++;
	}?>
	</p>

</div>
<?
//var_dump($usesQuery);
//var_dump($query);
?>

usesQuery
query