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

$(document).ready(function(){
	$('.progress-button').hide(); 
  $.ajax({
    url: '$profileUrlz',
    success: function(data) {
        $('.profile-content').html(data);
     }
    });

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

  $('.close-arrow').click(function(){
     $('.profile-container').css({
       'width':'300px',
       'min-height':'1px',
       'visibility':'hidden'
      });
      $('.profile-content').hide();
      setTimeout(function() { 
        $('.sider').show('slow');
    }, 900);
      
	});
  });
JS;
$this->registerJs($profileUser);
?>