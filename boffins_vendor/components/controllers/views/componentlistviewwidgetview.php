
</style>
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Folder */
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
		background: #fff;
		position: relative;
		box-shadow: inset 0 -1px 0 0 rgba(100,121,143,0.122);
		
	}
	.active-component-tr{
		box-shadow: inset 1px 0 0 #dadce0,inset -1px 0 0 #dadce0,0 1px 2px 0 rgba(6, 81, 18, 1),0 1px 3px 1px rgba(60,64,67,.15) !important;
		z-index:1;
	}
	#listtable tr:hover{
		box-shadow: inset 1px 0 0 #dadce0,inset -1px 0 0 #dadce0,0 1px 2px 0 rgba(63, 81, 181, 1),0 1px 3px 1px rgba(60,64,67,.15);
		z-index:2;
		
	}

	
	h1{
            font-size:30px;
        }
        /*Table Style One*/
        .table .table-header{
            background:#FEC107;
            color:#333;
        }
        .table .table-header .cell{
            padding:20px;
        }
        @media screen and (max-width: 640px){
            table {
                overflow-x: auto;
                display: block;
            }
            .table .table-header .cell{
                padding:20px 5px;
            }
        }
</style>
<section>
<?
	$component = [
	['component-id' => 1,'title' => 'this is a new invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	
	['component-id' => 2,'title' => 'this is a second invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 3,'title' => 'this is another  invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 4,'title' => 'lets  try a new invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 5,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 6,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 7,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 8,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 9,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 10,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 11,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 12,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 13,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 14,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 15,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 16,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 17,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 18,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 19,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 20,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 21,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 22,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 23,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 24,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 25,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 26,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 27,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 28,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 29,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 30,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 31,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 32,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 33,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 34,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 35,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 36,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	['component-id' => 37,'title' => 'this is a new invoice and its the last invoice','templateObject'=>['id' => 1,],'attributeObject' =>['value1','value2','value3'],'value_data_type' => 'string'],
	];
	?>

            <table id="listtable" class="table">
				<thead>
                <tr class="table-header">
                    <th class="cell">Title</th>
                    <th class="cell">Value1</th>
                    <th class="cell">Value2</th>
                    <th class="cell">value2</th>
                    
                </tr>
				</thead>
				<tbody>
					<? foreach($component as $key => $value){?>
					<tr  class="component-table-tr one-time-component-click<?= $value['component-id'];?>" data-componentid="<?= $value['component-id'];?>">
                    <td><?= $value['title'];?></td>
					<? foreach($value['attributeObject'] as $key2 => $value2){?>
                    <td><?= $value2;?></td>
                    
                    <? };?>
                	</tr>
					<? };?>
                
				</tbody>
                
            </table>
        

</section>
<?
$viewUrl = Url::to(['component/view']);
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
		alert(1234);
	}else{
		$('#listtable_wrapper .row:first-child').hide();
	}
	
})

$(document).on('click','.input-sm',function(){
	$(this).addClass('keep-search-bar');
})

$(document).on('click','.component-table-tr',function(){
	clickedElement = $(this);
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




