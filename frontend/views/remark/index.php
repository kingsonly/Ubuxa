<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RemarkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
 

<div id="flux" style="width:200px;height:150px;overflow:auto;">
    <div class="rows">
        <div class="results">
        </div>
    </div>
</div>

<?php 
$remarkUrl = Url::to(['remark/index','src' => 'ref1']);

$jqueryscript = <<<JS
var mypage = 1;
mycontent(mypage);
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
    $.post('$remarkUrl',
    {page:mypage},
    function(data){
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