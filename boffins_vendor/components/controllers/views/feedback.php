<?php
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  use yii\helpers\Url;
?>
<style>
	.feedback-container {
  width: 100%;
  margin: 20px auto;
}

.feedback-button {
  background-color: #00a65a;
  border: 0px;
  padding: 10px;
  border-radius: 3px;
  margin: 0px;
  text-align: left;
  font-size: 16px;
  font-family: Raleway, Helvetica, Arial;
  text-transform: uppercase;
  font-weight: bold;
  letter-spacing: 1px;
  color: white;
  text-decoration: none !important;
  position: absolute;
  right: 60px;
  top: 5px;
}
.feedback-submit {
  background-color: #00a65a;
  border: 0px;
  padding: 10px;
  border-radius: 3px;
  margin: 0px;
  text-align: left;
  font-size: 16px;
  font-family: Raleway, Helvetica, Arial;
  text-transform: uppercase;
  font-weight: bold;
  letter-spacing: 1px;
  color: white;
  text-decoration: none !important;
}

.feedback-wrap {
  margin: 5px 0;
  display: block;
  text-align: left;
}

.feedback-form-widget {
  width: 400px;
  border-top: 3px solid #00a65a;
  margin: 0px auto;
  padding: 20px;
  background-color: #ffffff;
  font-family: Raleway, Helvetica, Arial;
  line-height: 20px;
  box-shadow: 0 0 70px rgba(0,0,0,0.4);
  position: relative;
}

.feedback-form-widget.closed {
  display: none;
}

.feedback-form-widget.open {
  display: block;
}

.close-feedback-widget {
  float: right;
  right: 5px;
  top: 5px;
  position: absolute;
  display: inline-block;
  color: #000;
  font-weight: 900;
  background-color: #f7f7f7;
  text-decoration: none;
  padding: 5px 10px;
  border-radius: 50%;
}

.feedback-input {
     border: 1px solid #00a65a;
    font-family: Raleway,sans-serif;
    -webkit-font-feature-settings: "lnum";
    font-feature-settings: "lnum";
    margin: 0px;
    padding: 10px;
    width: calc(100% - 20px);
    font-size: 16px;
}

.feedback-textarea {
    width: calc(100% - 5px);
    height: 120px;
    line-height: 20px;
    font-size: 16px;
    border: 1px solid #3d1951;
    resize: vertical;
}

.feedback-label {
  font-weight: 700;
  color: #3d1951;
  width: auto;
}
.feedback-contain{
	text-align: center;
  position: absolute;
  z-index: 9999;
  margin-top: 35px;
  right: 50px;
  top: 5px;
}
#feed-loader{
  display: none;
  height: 25px;
}


</style>
<div class="feedback-contain">
	<div class="feedback-overlay">
	  <div class="feedback-container">
	    
	  </div>
	</div>

	<div class="feedback-form-widget closed" wstyle="text">
	    <a href="#" id="close-feedback-form" class="close-feedback-widget" title="Close">X</a>
          <?php $form = ActiveForm::begin([ 'options' => ['class' => 'feedback-form', 'id' => 'createfeedback']]); ?>
	        <div class="feedback-wrap">
	          <label class="feedback-label">Feedback </label>
            <?= $form->field($feedback, 'user_comment')->textarea(['maxlength' => true, 'class' => 'feedback-textarea']) ?>
	        </div>
          <?= Html::submitButton('Submit Feedback <img id="feed-loader" src="images/ubuxaloader.gif"/>',['class' => 'feedback-submit']) ?>
        <?php ActiveForm::end(); ?>
	</div>
</div>
<?php
$feedbackUrl = Url::to(['user-feedback/create']); 
$feedbackJs = <<<JS
	$('#open-feedback-form').click(function () {
  $('.feedback-form-widget').removeClass('closed').addClass('open');
  $('body').addClass('modal-active');
    });

$('#close-feedback-form').click(function () {
  $('.feedback-form-widget').addClass('closed').removeClass('open');
  $('body').addClass('modal-active');
    });

$('#createfeedback').on('beforeSubmit',function(e) {
           var form = $(this);
           e.preventDefault();
           e.stopImmediatePropagation();
           $('#feed-loader').show();
            $.ajax({
                url: '$feedbackUrl',
                type: 'POST',
                data: form.serialize(),
                success: function(response) { 
                    console.log('completed');
                    $('#feed-loader').hide();
                    $('.feedback-form-widget').addClass('closed').removeClass('open');
                    $('.feedback-textarea').val('');
                    toastr.success('Feedback sent. Thank you!');
                },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
            });
      return false
});



JS;
 
$this->registerJs($feedbackJs);
?>