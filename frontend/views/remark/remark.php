 <?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Remark */

?>

<div id="flux" style="width:200px;height:150px;overflow:auto;">
<?php 
        foreach ($remarks as $key => $remark) {
    ?>
    <div class="rows">
        <div class="results">
            <div class="well"><?php  echo $remark['id']; ?></div>
        </div>
    </div>
<?php } ?>

</div>

<?php 
$remarkUrl = Url::to(['remark/index','src' => 'ref1']);

$jqueryscript = <<<JS
var mypage = 1;
jQuery(
  function($)
  {
    $('#flux').bind('scroll', function()
                              {
                                if($(this).scrollTop() + $(this).innerHeight()>=$(this)[0].scrollHeight)
                                {
                                  mypage++;
                                  mycontent(mypage);
                                }
                              })
  }
);

function mycontent(mypage){
    $('#ani_img').show();
    $.post('$remarkUrl',{page:mypage},function(data){
        alert(data.remarks);
        if(data.trim().lenght == 0){
            $('#loading').text('finished');
        }
        $('.results').append(data);
        $('.well').animate({srollTop: $('#loading').offset().top},5000,'easeOutBounce');
        $('#ani_img').hide();
        })
}

JS;
 
$this->registerJs($jqueryscript);
?>