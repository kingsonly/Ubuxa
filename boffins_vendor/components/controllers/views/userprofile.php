<?php
use boffins_vendor\components\controllers\ViewBoardWidget;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<style>
  .profile-container{
  overflow: scroll;
  visibility: hidden;
  width:300px;
  min-height:1px;
  background:#fff;
}
</style>

  <div class="profile_div">
  	<a class="profile-link set-profile" href="#">Edit profile</a>
  	<div class="profile_content"></div>
  </div>


<?php
$profileUrlz = Url::to(['user/update']);
$profileUser = <<<JS

$('.container').on('click', '.profile-link',function(){
	$.ajax({
    url: '$profileUrlz',
    success: function(data) {
        $('.profile-content').html(data);
     }
    });
});

$(document).ready(function(){ 

$('.set-profile').click(function(){
     $('.profile-container').css({
       'visibility':'visible',
       '-webkit-transition':'width 2s',
       'transition':'width 2s, height 2s',
       'width':'600px',
       'min-height':'500px'
      });
      $('.sider').hide('slow');
      $('.profile-content').show('slow');
  })

  
  });
JS;
$this->registerJs($profileUser);
?>