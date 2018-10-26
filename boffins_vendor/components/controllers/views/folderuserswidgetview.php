<?
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\select2\Select2; // or kartik\select2\Select2
use yii\web\JsExpression;
use frontend\models\InviteUsers;
use yii\widgets\ActiveForm;
$userModel = new InviteUsers();
$url = Url::to(['folder/users']);
$url2 = Url::to(['folder/add-users','id' => $id]);
?>
<style>
	.img-circular{
 width: 30px;
 height: 30px;
 background-repeat: no-repeat;
 background-size: cover;
border:solid 1px #666;
 border-radius: 15px;
 -webkit-border-radius: 15px;
 -moz-border-radius: 15px;
background-color: #fff;
transition: margin-top 0.1s ease-out 0s;
}
	.user-name{
		color: #666;
		font-size: 13px;
		/*margin-left: 1px;
		position: absolute;
		height: 30px;
		padding-top: 7.3px;*/
	}

	.folderusers{
		display: flex;
		flex: 1;
		height: 47px;
		width: 100%;
	}
	.user-container{
		/*width: 80px;
		overflow: hidden;*/
	}
	#invitenewuser{
		display: inline-block;
		height: 30px;
		padding-top: 8px;
		margin-right: 5px;
		text-transform: uppercase;
	    font-weight: bold;
	    font-size: 0.9em;
	    color: #bbb;
	}
	
	#plus-button{
		display: inline-block;
		
		padding-top: 4px;
		margin: 0 19px;
		width: 2em;
		 height: 2em;
				
		 border-radius: 50%;
		 -webkit-border-radius: 50%;
		 -moz-border-radius: 50%;
		text-align: center;
	}
	.fa-plus.users{
		width:20px;
		height: 20px;
		background: #ccc;
		border-radius: 15px;
 -webkit-border-radius: 15px;
 -moz-border-radius: 15px;
		padding-top: 3.5px;
		color:greenyellow !important;
	}

	.glyphicon-plus-sign{
		color: rgb(7, 71, 166);
		border-radius: 15px;
	    -webkit-border-radius: 15px;
		-moz-border-radius: 15px;
		font-size:2em;
		cursor: pointer;
	}
	.user-container{
		margin-bottom: 10px;
	}
	.user-sticker{
		display: flex;
	  	justify-content: center;
	  	margin-right: 5px;
	  	padding: 5px;
	  	text-align: center;
		border-radius: 30px;
		box-shadow: 5px 5px 1px #ccc;
	}
	.auth-user{
		text-transform: uppercase;
    font-weight: bold;
    font-size: 0.8em;
    color: #c5c7cc;
	}
	.user-image{
        position: relative;
        
    }
    .images{
        width:35px;
        height:35px;
        border: 1px solid #fff;
        background-repeat: no-repeat;
 		background-size: cover;
        border-radius: 50%;
        display: inline-block;
        margin-left: -8px;
        -webkit-transition: width 0.2s;
        -webkit-transition: height 0.2s;
        transition: width 0.2s;
        transition: height 0.2s;
    }
    
    .images:hover{
        cursor: pointer;
    }
    
	</style>
<div class="folderusers">
	<? if($removeButtons !== false){?>
	<div id="invitenewuser">AUTHORIZED USERS</div>
	<? var_dump($removeButtons)?>
	
	<div class="dropdown">
		<span id="plus-button" class="dropdown-toggle" id="dropdownMenuButtons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-plus-sign" data-toggle="tooltip-user" data-placement="bottom" title="add new user"></i></span>
	
	
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtons">
							<li id="" class="">
	<?$form = ActiveForm::begin(['action'=>Url::to(['folder/add-users']),'id' => 'add-new-user']); ?>
	<?= $form->field($userModel, 'users[]')->widget(Select2::classname(), [
     // set the initial display text
    'options' => ['placeholder' => 'Search for a user ...', 'multiple' => true],
'pluginOptions' => [
    'allowClear' => true,
	'tags' => true,
     'tokenSeparators' => [',', ' '],
    'minimumInputLength' => 3,
    'language' => [
        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
    ],
    'ajax' => [
        'url' => $url,
        'dataType' => 'json',
        'data' => new JsExpression('function(params) { return {q:params.term}; }')
    ],
    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
    'templateResult' => new JsExpression('function(user) { return user.surname + user.first_name ; }'),
    'templateSelection' => new JsExpression('function (user) { return user.surname +" " + user.first_name ;}'),
],
]);
	?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
							</li>
                        </div>
                        </div>
	<? }?>
	
	
	<div class="user-image">
	<?php $count= count($attributues); ?>
<?php foreach($attributues as $users){ 
	$image = !empty($users["image"])?$users["image"]:'default-user.png';
	$count--;
	?>
		
		    <div class="images blue" data-toggle="tooltip" data-id="<?php echo $count;?>" data-placement="bottom" title="<?= $users->fullName;?>" style="position: relative;z-index:<?php echo $count;?>;background-image:url('<?= Url::to('@web/images/users/'.$image); ?>')"></div>
		
	
	
	<? }; ?>
	</div>
	</div>
<?php 
$userJs = <<<JS

	$('.images').mouseenter(function(){
    $(this).css({
        'height':'40px',
        'width':'40px',
        'z-index':'10000',
                })
	}).mouseleave(function(){
	var getZindex = $(this).data('id');
	console.log(getZindex);
    $(this).css({
        'height':'35px',
        'width':'35px',
         'z-index':getZindex,
                })
	})
	$('[data-toggle="tooltip-user"]').tooltip();
	$('[data-toggle="tooltip"]').tooltip();
	
	
	
	
	
	$('body').on('beforeSubmit', '#add-new-user', function () {
     var form = $(this);
     // return false if form still have some validation errors
     if (form.find('.has-error').length) {
          return false;
     }
     // submit form
     $.ajax({
          url: '$url2',
          type: 'post',
          data: form.serialize(),
          success: function (response) {
               // do something with response
			   alert(3456)
          }
     });
     return false;
});

  
JS;

$this->registerJs($userJs);
?>