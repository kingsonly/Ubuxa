<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use frontend\models\Country;
use yii\helpers\ArrayHelper;
use yii\web\View;

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
.tab-content{
}
.tab-group {
  list-style: none;
  padding: 0;
  margin: 0 0 40px 0;
}
.tab-group:after {
  content: "";
  display: table;
  clear: both;
}
.tab-group li a {
  display: block;
  text-decoration: none;
  padding: 15px;
  background: rgba(160, 179, 176, .25);
  color: #a0b3b0;
  font-size: 20px;
  float: left;
  width: 50%;
  text-align: center;
  cursor: pointer;
  transition: 0.5s ease;
}
.tab-group li a:hover {
  background: #179b77;
  color: #fff;
}
.tab-group .active a {
  background: #1ab188;
  color: #fff;
}
.tab-content > div:last-child {
  display: none;
}

/* ///  DECORATION CSS ///  */
.dropdown {
  position: relative;
  display:block;
  margin-top:0.5em;
  padding:0;
}

/* This is the native select, we're making everything the text invisible so we can see the button styles in the wrapper */
.dropdown select {
  width:100%;
  margin:0;
  background:none;
  border: 1px solid transparent;
  outline: none;
  /* Prefixed box-sizing rules necessary for older browsers */
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  /* Remove select styling */
  appearance: none;
  -webkit-appearance: none;
  /* Magic font size number to prevent iOS text zoom */
  font-size:1.25em;
  /* General select styles: change as needed */
  /* font-weight: bold; */
  color: #444;
  padding: .6em 1.9em .5em .8em;
  line-height:1.3;
}
.dropdown select,
label {
  font-family: AvenirNextCondensed-DemiBold, Corbel, "Lucida Grande","Trebuchet Ms", sans-serif;
}

/* Custom arrow sits on top of the select - could be an image, SVG, icon font, etc. or the arrow could just baked into the bg image on the select */

.dropdown::after {
  content: "";
  position: absolute;
  width: 9px;
  height: 8px;
  top: 50%;
  right: 1em;
  margin-top:-4px;
  z-index: 2;
  background: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 12'%3E%3Cpolygon fill='rgb(102,102,102)' points='8,12 0,0 16,0'/%3E%3C/svg%3E") 0 0 no-repeat;  
  /* These hacks make the select behind the arrow clickable in some browsers */
  pointer-events:none;
}

/* This hides native dropdown button arrow in IE 10/11+ so it will have the custom appearance, IE 9 and earlier get a native select */
@media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {
  .dropdown select::-ms-expand {
    display: none;
  }
  /* Removes the odd blue bg color behind the text in IE 10/11 and sets the text to match the focus style text */
  select:focus::-ms-value {
    background: transparent;
    color: #222;
  }
}

/* Firefox >= 2 -- Older versions of FF (v2 - 6) won't let us hide the native select arrow, so we'll just hide the custom icon and go with native styling */
/* Show only the native arrow */
body:last-child .dropdown::after, x:-moz-any-link {
  display: none;
}
/* reduce padding */
body:last-child .dropdown select, x:-moz-any-link {
  padding-right: .8em;
}

/* Firefox 7+ -- Will let us hide the arrow, but inconsistently (see FF 30 comment below). We've found the simplest way to hide the native styling in FF is to make the select bigger than its container. */
/* The specific FF selector used below successfully overrides the previous rule that turns off the custom icon; other FF hacky selectors we tried, like `*>.dropdown::after`, did not undo the previous rule */

/* Set overflow:hidden on the wrapper to clip the native select's arrow, this clips hte outline too so focus styles are less than ideal in FF */
_::-moz-progress-bar, body:last-child .dropdown {
  overflow: hidden;
}
/* Show only the custom icon */
_::-moz-progress-bar, body:last-child .dropdown:after {
  display: block;
}
_::-moz-progress-bar, body:last-child .dropdown select {
  /* increase padding to make room for menu icon */
  padding-right: 1.9em;
  /* `window` appearance with these text-indent and text-overflow values will hide the arrow FF up to v30 */
  -moz-appearance: window;
  text-indent: 0.01px;
  text-overflow: "";
  /* for FF 30+ on Windows 8, we need to make the select a bit longer to hide the native arrow */
  width: 110%;
}

/* At first we tried the following rule to hide the native select arrow in Firefox 30+ in Windows 8, but we'd rather simplify the CSS and widen the select for all versions of FF since this is a recurring issue in that browser */
/* @supports (-moz-appearance:meterbar) and (background-blend-mode:difference,normal) {
.dropdown select { width:110%; }
}   */


/* Firefox 7+ focus style - This works around the issue that -moz-appearance: window kills the normal select focus. Using semi-opaque because outline doesn't handle rounded corners */
_::-moz-progress-bar, body:last-child .dropdown select:focus {
  outline: 2px solid rgba(180,222,250, .7);
}


/* Opera - Pre-Blink nix the custom arrow, go with a native select button */
x:-o-prefocus, .dropdown::after {
  display:none;
}


/* Hover style */
.dropdown:hover {
  border:1px solid #888;
}

/* Focus style */
select:focus {
  outline:none;
  box-shadow: 0 0 1px 3px rgba(180,222,250, 1);
  background-color:transparent;
  color: #222;
  border:1px solid #aaa;
}


/* Firefox focus has odd artifacts around the text, this kills that */
select:-moz-focusring {
  color: transparent;
  text-shadow: 0 0 0 #000;
}

option {
  font-weight:normal;
}


/* These are just demo button-y styles, style as you like */
.button-select {
  border: 1px solid #bbb;
  border-radius: .3em;
  box-shadow: 0 1px 0 1px rgba(0,0,0,.04);
  background: #f3f3f3; /* Old browsers */
  background: -moz-linear-gradient(top, #ffffff 0%, #e5e5e5 100%); /* FF3.6+ */
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#e5e5e5)); /* Chrome,Safari4+ */
  background: -webkit-linear-gradient(top, #ffffff 0%,#e5e5e5 100%); /* Chrome10+,Safari5.1+ */
  background: -o-linear-gradient(top, #ffffff 0%,#e5e5e5 100%); /* Opera 11.10+ */
  background: -ms-linear-gradient(top, #ffffff 0%,#e5e5e5 100%); /* IE10+ */
  background: linear-gradient(to bottom, #ffffff 0%,#e5e5e5 100%); /* W3C */
}

.output {
  margin: 0 auto;
  padding: 1em; 
}
.colors {
  padding: 2em;
  color: #fff;
  display: none;
}
.red {
  background: #c04;
} 
.yellow {
  color: #000;
  background: #f5e000;
} 

.blue {
  background: #079;
}
.skin-red .wrapper, .skin-red{
	background:#fff !important;
}
</style>
<div class="form">
      
      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Create new</a></li>
        <li class="tab"><a href="#login" class="existing">Use existing</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="signup">   
    
  <div class="client-container">
    <div class="wrapper-form">
      <ul class="steps">
        <li class="is-active">Step 1</li>
        <li>Step 2</li>
        <li>Step 3</li>
      </ul>
      <?php $form = ActiveForm::begin(['options' => [
                    'class' => 'form-wrapper supplier-form'
                 ]
         ]); ?>
      <form class="form-wrapper">
        <fieldset class="section is-active">
          <h3 style="text-align: center">Client Details</h3>
          <?= $form->field($coperationModel, 'name')->textInput(['placeholder' => "Corporation Name"])->label(false); ?>
          <?= $form->field($coperationModel, 'short_name')->textInput(['placeholder' => "Corporation Short Name"])->label(false); ?>
          <?= $form->field($model, 'supplier_type')->textInput(['maxlength' => true,'placeholder' => "Supplier type"])->label(false); ?>
          <?= $form->field($coperationModel, 'notes')->textInput(['placeholder' => "Leave a note"])->label(false);  ?>

        <?= $form->field($model, 'notes')->hiddenInput(['maxlength' => true])->label(false); ?>

          <div class="button">Next</div>
        </fieldset>
        <fieldset class="section">
          <h3 style="text-align: center">More Details</h3>
            <?= $form->field($telephoneModel, 'telephone_number')->textInput(['maxlength' => true, 'placeholder' => "Supplier Telephone"])->label(false); ?>
        <?= $form->field($emailModel, 'address')->textInput(['maxlength' => true,'placeholder' => "Supplier email address"])->label(false);?>
        <?= $form->field($addressModel, 'address_line')->textInput(['maxlength' => true,'placeholder' => "Supplier address line"])->label(false);?>
        
          <div class="button">Next</div>
        </fieldset>
        <fieldset class="section">
          <h3>Select Country</h3>
          <?= $form->field($addressModel, 'country_id')->dropDownList(ArrayHelper::map(Country::find()->all(),'id','name'), ['id'=>'cat-id']); ?>
      <?= $form->field($addressModel, 'state_id')->widget(DepDrop::classname(), [
         'options' => ['id'=>'subcat-id'],
         'pluginOptions'=>[
             'depends'=>['cat-id'],
             'placeholder' => 'Select...',
             'url' => Url::to(['/client/subcat'])
         ]
      ]); ?>
          <?= Html::submitButton('Finish', ['class' => 'btn btn-success supplier-submit']) ?>
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

        </div>
        
        <div id="login">   
<label class="wrapper" for="states">Select already existing Corporation.</label>
<div class="button-select dropdown"> 
  <select id="colorselector">
  	<? if(!empty($getExistingCorperation)){
  	 foreach($getExistingCorperation as $existing){?>
     <option value="<?= $existing['id']; ?>" id="<?= $existing['id']; ?>" class='select-corporation'><?= $existing['name']; ?></option>
    <? } } ?>
  </select>
</div>

<div class="output">
  <div id="blue" class="colors blue"></div>
  <div  class="error_supplier" style="color:red"></div>
</div>



	
        </div>
        
      </div><!-- tab-content -->
      
</div> <!-- /form -->
<?php 
$supplierUrlSave = Url::to(['supplier/create']);
$supplierUrlExisting = Url::to(['supplier/create','src' => 'existing']);
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

$('.supplier-form').submit(function(e){
	var form = $(this);
	$.ajax({
           type: "POST",
           url: '$supplierUrlSave',
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
               form.find("input[type=text], textarea, select").val("");
               $('.supplier-submit').prepend('<p>Supplier submitted successfully</p>');
               alert(data);
           }
         });

    e.preventDefault(); // avoid to execute the actual submit of the form.
	})

	$('.form').find('input, textarea').on('keyup blur focus', function (e) {
  
  	  var \$this = $(this),
      label = \$this.prev('label');

	  if (e.type === 'keyup') {
			if (\$this.val() === '') {
          label.removeClass('active highlight');
        } else {
          label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
    	if( \$this.val() === '' ) {
    		label.removeClass('active highlight'); 
			} else {
		    label.removeClass('highlight');   
			}   
    } else if (e.type === 'focus') {
      
      if( \$this.val() === '' ) {
    		label.removeClass('highlight'); 
			} 
      else if( \$this.val() !== '' ) {
		    label.addClass('highlight');
			}
    }

});

$('.tab a').on('click', function (e) {
  
  e.preventDefault();

  if($(this).hasClass('existing')){
  	$('.tab-content').css({'background':'#fff','padding':'10px'});
  } else {
  	$('.tab-content').css({'background':'transparent','padding':'0px'});
  }
  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');
  
  target = $(this).attr('href');

  $('.tab-content > div').not(target).hide();
  
  $(target).fadeIn(600);
  
});

$('.cont_select_int li').click(function(){
	alert(566787);
	})
$(function() {
  $('#colorselector').change(function(){
  	var get_text = $(this);
  	var existingId = $(this).find("option:selected").attr("id");
  	$.ajax({
                url: '$supplierUrlExisting',
                type: 'POST',
                dataType: 'json',
                data: {
                		existingId:existingId
                	},
                success: function(response) {
  					
    				if (!response.success)
    					var corporation = get_text.find("option:selected").text();
                        $('.colors').hide();
                        $('.error_supplier').text();
    				    $('#blue').html('you have added <strong>'+ corporation + '</strong> as a new supplier');
    				    $('#blue').show();
    					console.log(response.msg);
                },
                error: function(res, sec){
                  $('.error_supplier').text('Something went wrong');
              }
            }); 
    
  });
});
JS;
 
$this->registerJs($clientFormJs, View::POS_END);
?>

