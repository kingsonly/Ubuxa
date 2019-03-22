<?php
  use frontend\assets\AppAsset;
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  use yii\helpers\Url;
  use yii\base\view;
  AppAsset::register($this);
?>
<style>
  .content-wrapper {
  width: 320px;
  margin: 0 auto;
}

.card-loader {
  background-color: #fff;
  padding: 8px;
  position: relative;
  border-radius: 2px;
  margin-bottom: 0;
  height: 200px;
  overflow: hidden;
}
.card-loader:only-child {
  margin-top: 0;
}
.card-loader:before {
  content: '';
  height: 110px;
  display: block;
  background-color: #ededed;
}
.card-loader:after {
  content: '';
  background-color: #333;
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  animation-duration: 0.86s;
  animation-iteration-count: infinite;
  animation-name: loader-animate;
  animation-timing-function: linear;
  background: -webkit-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.6) 30%, rgba(255, 255, 255, 0) 81%);
  background: -o-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.6) 30%, rgba(255, 255, 255, 0) 81%);
  background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.6) 30%, rgba(255, 255, 255, 0) 81%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#00ffffff',GradientType=1 );
}
.second-one{
  margin-top: -80px;
}
.first-one{
  margin-top: 10px;
}
@keyframes loader-animate {
  0% {
    transform: translate3d(-100%, 0, 0);
  }
  100% {
    transform: translate3d(100%, 0, 0);
  }
}

</style>
<div class="content-loader">
      <div class="content-wrapper first-one">
        <div class="card-loader card-loader--tabs"></div>
      </div>

      <div class="content-wrapper second-one">
        <div class="card-loader card-loader--tabs"></div>
      </div>

      <div class="content-wrapper second-one">
        <div class="card-loader card-loader--tabs"></div>
      </div>

      <div class="content-wrapper second-one">
        <div class="card-loader card-loader--tabs"></div>
      </div>
    </div>
</div>