
</style>
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Folder */
$loader = Yii::$app->settingscomponent->boffinsLoaderImage();
?>
<style>
	
	#listtable_wrapper .row:first-child{
		display: none;
	}
	#listtable{
	table-layout: fixed;
	width: 100%;
	border-spacing: 0;
	padding: 0;
	}
	
	#listtable tr{
		position: relative;
		box-shadow: inset 0 -1px 0 0 rgba(100,121,143,0.122);
		
	}
	.active-component-tr{
		box-shadow: inset 1px 0 0 #dadce0,inset -1px 0 0 #dadce0,0 1px 2px 0 rgba(6, 81, 18, 1),0 1px 3px 1px rgba(60,64,67,.15) !important;
		z-index:1;
	}
	#listtable .component-table-tr:hover{
		box-shadow: inset 1px 0 0 #dadce0,inset -1px 0 0 #dadce0,0 1px 2px 0 rgba(63, 81, 181, 1),0 1px 3px 1px rgba(60,64,67,.15);
		z-index:2;
		cursor: pointer;
		
	}

	
	h1{
            font-size:30px;
        }
        /*Table Style One*/
        
        
     
	
</style>
<section>

            <table id="listtable" class="table">
				<thead>
                <tr class="table-header">
					<th class="cell">Title</th>
					<? $attributeNameHolder = []; if(!empty($content)){?>
						<? $i=1;foreach($content as $key => $value){?>
						<? if($i === 1){ ?>
							<? foreach($value->getComponentAttributeShowInGrid() as $key => $componentDetails){?>
								<? array_push($attributeNameHolder,$componentDetails['name']);?>
                    			
                    		<? };?>
						<? }?>
							
						<? $i++; }?>
					<?}?>
                    
                    <? foreach($attributeNameHolder as $valueHEader){;?>
						<th class="cell"><?= $valueHEader; ?></th>
                    <? };?>
                </tr>
				</thead>
	
				<tbody>
					<? foreach($content as $key => $value){?>
					<tr  class="component-table-tr one-time-component-click<?= $value['id'];?>" data-componentid="<?= $value['id'];?>">
                    <td><?= $value['title'];?></td>
					<? foreach($value->getComponentAttributeShowInGrid() as $key => $componentDetails){?>
                    <td><?= empty($componentDetails['value'])?$componentDetails['name'].' is empty':$componentDetails['value'];?>
						
						
						
						</td>
                    
                    <? };?>
                	</tr>
					<? };?>
                
				</tbody>
                
            </table>
        

</section>
<?
$viewUrl = Url::to(['component/view','folderId' => $folderId]);
$listViewJs = <<<listViewJs

$("#listtable").DataTable({
	"aaSorting": [],
	"responsive": "true",
	"pagingType": "simple",
});
$('#listtable_wrapper').hover(function(){
	$('#listtable_wrapper .row:first-child').show();
},function(e){
	if($(document).find('#listtable_wrapper .input-sm').hasClass('keep-search-bar')){
		
	}else{
		$('#listtable_wrapper .row:first-child').hide();
	}
	
})

$(document).on('click','.input-sm',function(){
	$(this).addClass('keep-search-bar');
	
})

// note adding .off() would break the rest of the js on the page  
$('body').off().on('click','.component-table-tr',function(e){
	clickedElement = $(this);
	$("#view").html('<div style="width:100%;height:150px;margin-top:5%;text-align:center">$loader</div>');
	getComponentId = clickedElement.data('componentid');
	$(document).find('.component-table-tr').removeClass('active-component-tr')
	clickedElement.addClass('active-component-tr');
	$("#listView").removeClass('col-xs-12');
	$("#view-content").removeClass('col-xs-5');
	$("#view-content").addClass('col-xs-4').show();
	$("#listView").addClass('col-xs-8').find('#listtable').css('table-layout','auto');
	$("#view").load('$viewUrl&id='+getComponentId);
})

listViewJs;
 
$this->registerJs($listViewJs);
?>




