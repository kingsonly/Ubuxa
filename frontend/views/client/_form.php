<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use frontend\models\Country;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
html, body{
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
  font-family: 'Open Sans', sans-serif;
  background-color: #3498db;
}

h1, h2, h3, h4, h5 ,h6{
  font-weight: 200;
}

a{
  text-decoration: none;
}

p, li, a{
  font-size: 14px;
}

fieldset{
  margin: 0;
  padding: 0;
  border: none;
}

/* GRID */

.twelve { width: 100%; }
.eleven { width: 91.53%; }
.ten { width: 83.06%; }
.nine { width: 74.6%; }
.eight { width: 66.13%; }
.seven { width: 57.66%; }
.six { width: 49.2%; }
.five { width: 40.73%; }
.four { width: 32.26%; }
.three { width: 23.8%; }
.two { width: 15.33%; }
.one { width: 6.866%; }

/* COLUMNS */

.col {
	display: block;
	float:left;
	margin: 0 0 0 1.6%;
}

.col:first-of-type {
  margin-left: 0;
}

.client-container{
  width: 100%;
  max-width: 700px;
  margin: 0 auto;
  position: relative;
}

.row{
  padding: 20px 0;
}

/* CLEARFIX */

.cf:before,
.cf:after {
    content: " ";
    display: table;
}

.cf:after {
    clear: both;
}

.cf {
    *zoom: 1;
}

.wrapper-form{
  width: 100%;
  margin: 30px 0;
}

/* STEPS */

.steps{
  list-style-type: none;
  margin: 0;
  padding: 0;
  background-color: #fff;
  text-align: center;
}


.steps li{
  display: inline-block;
  margin: 20px;
  color: #ccc;
  padding-bottom: 5px;
}

.steps li.is-active{
  border-bottom: 1px solid #3498db;
  color: #3498db;
}

/* FORM */

.form-wrapper .section{
  padding: 0px 20px 30px 20px;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  background-color: #fff;
  opacity: 0;
  -webkit-transform: scale(1, 0);
  -ms-transform: scale(1, 0);
  -o-transform: scale(1, 0);
  transform: scale(1, 0);
  -webkit-transform-origin: top center;
  -moz-transform-origin: top center;
  -ms-transform-origin: top center;
  -o-transform-origin: top center;
  transform-origin: top center;
  -webkit-transition: all 0.5s ease-in-out;
  -o-transition: all 0.5s ease-in-out;
  transition: all 0.5s ease-in-out;
  text-align: center;
  position: absolute;
  width: 100%;
  min-height: 300px
}

.form-wrapper .section h3{
  margin-bottom: 30px;
}

.form-wrapper .section.is-active{
  opacity: 1;
  -webkit-transform: scale(1, 1);
  -ms-transform: scale(1, 1);
  -o-transform: scale(1, 1);
  transform: scale(1, 1);
}

.form-wrapper .button, .form-wrapper .submit{
  background-color: #3498db;
  display: inline-block;
  padding: 8px 30px;
  color: #fff;
  cursor: pointer;
  font-size: 14px !important;
  font-family: 'Open Sans', sans-serif !important;
  position: absolute;
  right: 20px;
  bottom: 20px;
}

.form-wrapper .submit{
  border: none;
  outline: none;
  -webkit-box-sizing: content-box;
  -moz-box-sizing: content-box;
  box-sizing: content-box;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
}
.form-control{
	width: 50% !important;
	margin: 10px auto !important;
}

.form-wrapper input[type="text"],
.form-wrapper input[type="password"]{
  display: block;
  padding: 10px;
  margin: 10px auto;
  background-color: #f1f1f1;
  border: none;
  width: 50%;
  outline: none;
  font-size: 14px !important;
  font-family: 'Open Sans', sans-serif !important;
}

.form-wrapper input[type="radio"]{
  display: none;
}

.form-wrapper input[type="radio"] + label{
  display: block;
  border: 1px solid #ccc;
  width: 100%;
  max-width: 100%;
  padding: 10px;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  cursor: pointer;
  position: relative;
}

.form-wrapper input[type="radio"] + label:before{
  content: "✔";
  position: absolute;
  right: -10px;
  top: -10px;
  width: 30px;
  height: 30px;
  line-height: 30px;
  border-radius: 100%;
  background-color: #3498db;
  color: #fff;
  display: none;
}

.form-wrapper input[type="radio"]:checked + label:before{
  display: block;
}

.form-wrapper input[type="radio"] + label h4{
  margin: 15px;
  color: #ccc;
}

.form-wrapper input[type="radio"]:checked + label{
  border: 1px solid #3498db;
}

.form-wrapper input[type="radio"]:checked + label h4{
  color: #3498db;
}

</style>

<div class="client-form" style="display:none">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'corporation_id')->textInput() ?>
    <?= $form->field($coperationModel, 'name')->textInput() ?>
    <?= $form->field($coperationModel, 'short_name')->textInput() ?>
    <?= $form->field($coperationModel, 'notes')->textInput() ?>
    <?= $form->field($telephoneModel, 'telephone_number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($emailModel, 'address')->textInput(['maxlength' => true]) ?>
    <?= $form->field($addressModel, 'address_line')->textInput(['maxlength' => true])?>
    <?= $form->field($addressModel, 'country_id')->dropDownList(ArrayHelper::map(Country::find()->all(),'id','name'), ['id'=>'cat-id']); ?>
	<?= $form->field($addressModel, 'state_id')->widget(DepDrop::classname(), [
     'options' => ['id'=>'subcat-id'],
     'pluginOptions'=>[
         'depends'=>['cat-id'],
         'placeholder' => 'Select...',
         'url' => Url::to(['/client/subcat'])
     ]
 	]); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
  <div class="client-container">
    <div class="wrapper-form">
      <ul class="steps">
        <li class="is-active">Step 1</li>
        <li>Step 2</li>
        <li>Step 3</li>
      </ul>
      <?php $form = ActiveForm::begin(['options' => [
                		'class' => 'form-wrapper'
            		 ]
         ]); ?>
      <form class="form-wrapper">
        <fieldset class="section is-active">
          <h3 style="text-align: center">Client Details</h3>
          <?= $form->field($coperationModel, 'name')->textInput(['placeholder' => "Corporation Name"])->label(false); ?>
          <?= $form->field($coperationModel, 'short_name')->textInput(['placeholder' => "Corporation Short Name"])->label(false); ?>
          <?= $form->field($coperationModel, 'notes')->textInput(['placeholder' => "Leave a note"])->label(false);  ?>
          <div class="button">Next</div>
        </fieldset>
        <fieldset class="section">
          <h3 style="text-align: center">More Details</h3>
            <?= $form->field($telephoneModel, 'telephone_number')->textInput(['maxlength' => true, 'placeholder' => "Client Telephone"])->label(false); ?>
		    <?= $form->field($emailModel, 'address')->textInput(['maxlength' => true,'placeholder' => "Client email address"])->label(false);?>
		    <?= $form->field($addressModel, 'address_line')->textInput(['maxlength' => true,'placeholder' => "Client address line"])->label(false);?>
		    
          <div class="button">Next</div>
        </fieldset>
        <fieldset class="section">
          <h3>Choose a Password</h3>
          <?= $form->field($addressModel, 'country_id')->dropDownList(ArrayHelper::map(Country::find()->all(),'id','name'), ['id'=>'cat-id']); ?>
			<?= $form->field($addressModel, 'state_id')->widget(DepDrop::classname(), [
		     'options' => ['id'=>'subcat-id'],
		     'pluginOptions'=>[
		         'depends'=>['cat-id'],
		         'placeholder' => 'Select...',
		         'url' => Url::to(['/client/subcat'])
		     ]
		 	]); ?>
          <?= Html::submitButton('Finish', ['class' => 'btn submit button']) ?>
        </fieldset>
        <fieldset class="section">
          <h3>Account Created!</h3>
          <p>Your account has now been created.</p>
          <div class="button">Reset Form</div>
        </fieldset>
      </form>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
<?php 
$clientFormJs = <<<JS

$(document).ready(function(){
  $(".form-wrapper .button").click(function(){
    var button = $(this);
    var currentSection = button.parents(".section");
    var currentSectionIndex = currentSection.index();
    var headerSection = $('.steps li').eq(currentSectionIndex);
    currentSection.removeClass("is-active").next().addClass("is-active");
    headerSection.removeClass("is-active").next().addClass("is-active");

    $(".form-wrapper").submit(function(e) {
      e.preventDefault();
    });

    if(currentSectionIndex === 3){
      $(document).find(".form-wrapper .section").first().addClass("is-active");
      $(document).find(".steps li").first().addClass("is-active");
    }
  });
});


JS;
 
$this->registerJs($clientFormJs);
?>
