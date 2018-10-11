<?
use yii\helpers\Url;
use app\boffins_vendor\components\controllers\EdocumentDisplay;
?>
<div style="margin-top:6px;">
<!-- 
this is the view file for the displaylinkecomponent widget
__________ Varialbel list and explanation __________________
1) subComponent = all subcomponent passed down by the controller 
2)getId = this variable holds individual component id from the loop
3)id = this is an actual implementation of  the getId variable
 _____________ HTML data property and usuage _________________
1) data-spanclass this is used to assign a class to the span from the jquery page end
2) data-url holds the url which would be called by Jquery load funtion to help display the component on a drageable  container

-->
	
	<? foreach($subComponents as $key => $value){ 
		$getId =  $value->component_classname::find()->where(["component_id" =>  $value->id])->one();
		$id = $getId->getPrimaryKey();
		?>
		<? 
		/*
		* Check for the availability of edocument component on the looped list
		* if it exist extract it using the component id
		* fetch the specific edocument and push the fetched file_location to $eDocumentSubcomponent
		* using keyword continue would aid in skiping the display of the edocumnet, 
		* as this would be handled by the edocument widget
		**/
		if($value->component_type == 'edocument'){
			$edocumentFilees = $edocumentModel->find()->where(['component_id' => $value->id])->one();
			array_push($eDocumentSubcomponent,$edocumentFilees->fileLocationString); // push edocument file_locations to eDocumentSubcomponent variable.
			continue;
		}?>
		<span class="btn fetchlinked" data-spanclass="<?= $value->component_type.$value->id?>" data-url="<?= Url::to([$value->component_type.'/'.$value->component_type.'view', 'id' => $id])?>"> <i class="fa fa-link" aria-hidden="true"></i><?=$value->component_type;?></span>
	<?}?>
</div>
<!--- Edocument display widget --->
<?= EdocumentDisplay::widget([
	'files'=>$files,
	'eDocumentSubcomponent'	=> $eDocumentSubcomponent
]); ?>

<!--- Dreagable div-->
<div id="dragablearea">

</div>



