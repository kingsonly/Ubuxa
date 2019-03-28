<?php
  use frontend\assets\AppAsset;
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  use yii\helpers\Url;
  use yii\base\view;
  AppAsset::register($this);
?>
<style>
@import url('//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');

.info-msg,
.success-msg,
.warning-msg,
.error-msg {
  margin: 10px 0;
  padding: 10px;
  border-radius: 3px 3px 3px 3px;
}
.info-msg {
  color: #059;
  background-color: #BEF;
  display: none;
}

</style>
 <div class="info-msg">
  <i class="fa fa-info-circle"></i>
  This is an info message.
</div>


<?php
$js = <<<JS
 (function(){
  $('.info-msg').slideDown('slow');
  })()
JS;
$this->registerJs($js);
?>

