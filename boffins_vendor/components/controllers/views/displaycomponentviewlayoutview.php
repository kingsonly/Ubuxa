<?php

use yii\helpers\Html;
use yii\helpers\Url;




/* @var $this yii\web\View */
/* @var $model app\models\Folder */



?>
<style>
	/*
.floatright{
	float: right;
}
	
.foldernote{
	line-height: 24px;
	text-underline-position: alphabetic;
	margin-top: 10px;
}
	
#loading{
	display:none;
}

#flash{
	display: none;
}

#componentviewcontent{
	background: #fff;
	margin-top: 22px;
	min-height: 600px;
}
	*/
	#view-content{
		box-shadow:  -8px 8px 25px -2px rgba(0, 0, 0, 0.1) !important;
	}
</style>


<section class="content">
	
	
  
      <div class="row">
          
		  	<div class="col-xs-12" id="listView">
					  
		  </div>
			  
		  <div id="view-content" class="col-xs-5" style="display:none;" >
			  
			  <div id="viewcontainer">
				  <div id="view">
				  <img class="loadergif" src="images/loader.gif"  />
				  </div>
			  </div>
		  </div>
    </div>
</section>

<?php 

	$urlListView = Url::to(['component/listview','folder'=>$folderId,'component' => $templateId]);
	
	
$js3 = <<<JS

$('table').tablesorter({
			widgets        : ['zebra', 'columns'],
			usNumberFormat : false,
			sortReset      : true,
			sortRestart    : true
		});

$("#listView").load('$urlListView');





JS;
 
$this->registerJs($js3);
?>