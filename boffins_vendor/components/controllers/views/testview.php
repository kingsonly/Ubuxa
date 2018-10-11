<?
use yii\helpers\Url;
?>
<div class="container">
    
    <div class="form-group">
      <div class="col-sm-10">
        <div class="example"></div><div class="example"></div>
      </div>
    </div>
  </div>

<?
$loadData = Url::to(['/address/apithings']);
 
?>

<?php 
$this->registerJsFile('@web/js/dist/js/bootstrap-cascader-dcbf0e3207.min.js');	
$this->registerCssFile('@web/js/specific.js');	



$testView = <<<js
	
    n = 0;
       
	   function test(){
	   	$.ajax({
  url: '$loadData',
  
  success: function(response){
  n = $.parseJSON(response);
  return n;
    
  },
  
});
	   }
            
        
		alert(test())
		
    $(".example").bsCascader({
        splitChar: " / ",
        btnCls: 'btn-primary',
        openOnHover: !0,
        lazy: !0,
        placeHolder: 'Select...',
		loadData: function (openedItems, callback) {
      callback(test());
    }
    })

js;
 
$this->registerJs($testView);
?>
