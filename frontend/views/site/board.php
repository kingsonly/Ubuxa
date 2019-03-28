<?php
  use frontend\assets\AppAsset;
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  use yii\helpers\Url;
  use yii\base\view;
  AppAsset::register($this);
?>
<style>
#breathing-button {
    width: 270px;
    padding: 20px;
    margin: 50px auto;
    border: 1px solid #d1d1d1;
    -webkit-animation: breathing 7s ease-out infinite normal;
    animation: breathing 7s ease-out infinite normal;
    font-size: 24px;
    background: #5885cb;
    color: #fff;
    -webkit-font-smoothing: antialiased;
    border-radius: 3px;
    text-align: center;    
    }


@-webkit-keyframes breathing {
  0% {
    -webkit-transform: scale(0.9);
    transform: scale(0.9);
  }

  25% {
    -webkit-transform: scale(1);
    transform: scale(1);
  }

  60% {
    -webkit-transform: scale(0.9);
    transform: scale(0.9);
  }

  100% {
    -webkit-transform: scale(0.9);
    transform: scale(0.9);
  }
}

@keyframes breathing {
  0% {
    -webkit-transform: scale(0.9);
    -ms-transform: scale(0.9);
    transform: scale(0.9);
  }

  25% {
    -webkit-transform: scale(1);
    -ms-transform: scale(1);
    transform: scale(1);
  }

  60% {
    -webkit-transform: scale(0.9);
    -ms-transform: scale(0.9);
    transform: scale(0.9);
  }

  100% {
    -webkit-transform: scale(0.9);
    -ms-transform: scale(0.9);
    transform: scale(0.9);
  }
}

</style>
<div id="breathing-button">Breathing Button</div>


<?php
$js = <<<JS
 
JS;
$this->registerJs($js);
?>

