<?
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\select2\Select2; // or kartik\select2\Select2
use yii\web\JsExpression;
use frontend\models\InviteUsers;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
$userModel = new InviteUsers();


if($type ===  'component'){
	$url = [];
	if(!empty($listOfUsers)){
		foreach($listOfUsers as $key => $value){
			$url[$value->id] = $value->username;
		}
	}
	$url2 = Url::to(['component/add-users','id' => $id]);;
	$option = [
    'allowClear' => true,
	'tags' => true,
     'tokenSeparators' => [',', ' '],
  
    'language' => [
        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
    ],
];
	
	$pluginSettings = [
		'data' =>$url,
     // set the initial display text
    'options' => ['placeholder' => 'Search for a user ...', 'multiple' => true,'id' => !empty($type)?$type.'user':'folderUser'],
'pluginOptions' => $option,
];
} else {
	
	$url = Url::to(['folder/users']);
	$url2 = Url::to(['folder/add-users','id' => $id]);
	$option = [
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
		
];
	$pluginSettings = [
     // set the initial display text
    'options' => ['placeholder' => 'Search for a user ...', 'multiple' => true,'id' => !empty($type)?$type.'user':'folderUser'],
'pluginOptions' => $option,
];
}
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
	.online{
		width: 8px;
		height: 8px;
		position: absolute;
		right: 0px;
		bottom: -2px ;
		background: green;
		border-radius: 50%;
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
		height: 43px;
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
    .images-offonline,.images-online{
        width:35px;
        height:35px;
        border: 1px solid #fff;
        background-repeat: no-repeat;
 		background-size: cover;
 		background-position: center;
        border-radius: 50%;
        display: inline-block;
        margin-left: -8px;
        -webkit-transition: width 0.2s;
        -webkit-transition: height 0.2s;
        transition: width 0.2s;
        transition: height 0.2s;
    }
	
	.images-online{
		border: 2px solid green !important;
	}
    
    .images-offonline:hover,.images-online:hover{
        cursor: pointer;
    }
    .select2-container--krajee .select2-selection--multiple .select2-search--inline .select2-search__field{
    	width: 100% !important;
    	padding-right: 100px !important;
    	border: 1px solid #ccc;
    	border-radius: 10px;
    }
    .select2-selection__choice{
    	margin-bottom: 6px;
    }
    .select2-selection__choice__remove{
    	margin: 0px 0 0 3px !important;
    	cursor: pointer;
    }
    .select2-selection__choice{
    	margin-bottom: 8px !important;
    }
    .select2-selection__clear{
    	top: -2.6rem !important;
    }
	
	.delete_user{
		position: absolute;
    	cursor: pointer;
		background: #0a0000;
		opacity: 1 !important;
		bottom: -7px;
		right: -7px;
		width: 17px;
		height: 17px;
		border-radius: 50%;
		display: none;
		z-index: 1000;
		font-family: Times, Times New Roman, Georgia, serif;
	}
	.blue:hover .delete_user{
		display: block;
	}
	
	.close__icon_users{
		font-size: 13px;
		color: aliceblue;
		text-decoration: solid;
		font-weight: bold;
		text-align: center;
	}
    
	</style>
<? if($type == 'component' ){?>
<div id="invitenewuser">
		<span>AUTHORIZED USERS</span>
	</div>
<? }?>
<div>

</div>
<div class="folderusers" id="folderusers<?=$dynamicId;?>">
	<? if($removeButtons !== false){?>
	<? if($type != 'component' ){?>
	<div id="invitenewuser">
		<span>AUTHORIZED USERS</span>
	</div>
	<? }?>
	
	<div class="dropdown">
		<span id="plus-button" class="dropdown-toggle" id="dropdownMenuButtons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-plus-sign" data-toggle="tooltip-user" data-placement="bottom" title="add new user"></i></span>
	
	
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtons">
							<li id="" class="">
	<?$form = ActiveForm::begin(['id' => $type.'add-new-user'.$id]); ?>
	<?= $form->field($userModel, 'users[]')->widget(Select2::classname(),$pluginSettings );
	?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
							</li>
                        </div>
                        </div>
	<? }?>
	
	<?php Pjax::begin(['id'=>'user_prefix'.$pjaxId]); ?>
	<div class="user-image user_image<?=$dynamicId;?>" >
	<?php $count = !empty($attributues)?count($attributues):0; ?>

<?php 
		if(!empty($attributues)){
			$socketUsers = Yii::$app->session['socketUsers'];
		foreach($attributues as $users){
			
	$image = !empty($users["profile_image"])?$users["profile_image"]:'images/users/default-user.png';
	$count--;
			?>
			<? if (!empty($socketUsers)) {?>
		
		<?	if (array_key_exists($users->username, $socketUsers)) {
    			if($socketUsers[$users->username] == 'Online'){
					?>
					<div class="images-online blue user-sticker<?=$users->id.'-'.$dynamicId;?>" data-userid="<?= $users->id;?>" data-toggle="tooltip" data-id="<?php echo $count;?>" data-placement="bottom" data-username="<?= $users->username;?>" data-userimage="<?= $image ?>" title="<?= $users->fullName;?>" style="position: relative;z-index:<?php echo $count;?>;background-image:url('<?= $image ?>')">
						<div class="online"></div>
						<div class="delete_user" ><div class="close__icon_users">x</div></div>
						
		</div>
				<? }else{ ?>
<!--					display user who is not online -->
					<div class="images-offonline blue user-sticker<?=$users->id.'-'.$dynamicId;?>" data-userid="<?= $users->id;?>" data-toggle="tooltip" data-id="<?php echo $count;?>" data-placement="bottom" data-username="<?= $users->username;?>" data-userimage="<?= $image ?>" title="<?= $users->fullName;?>" style="position: relative;z-index:<?php echo $count;?>;background-image:url('<?= $image ?>')">
					<div class="delete_user" ><div class="close__icon_users">x</div></div>
					</div>
		
				<? } ?>
			<? }else{ ?>
<!--				// display user never the less-->
		<div class="images-offonline blue user-sticker<?=$users->id.'-'.$dynamicId;?>" data-userid="<?= $users->id;?>"  data-toggle="tooltip" data-id="<?php echo $count;?>" data-placement="bottom" data-username="<?= $users->username;?>" data-userimage="<?= $image ?>"  title="<?= $users->fullName;?>" style="position: relative;z-index:<?php echo $count;?>;background-image:url('<?= $image ?>')">
		<div class="delete_user" ><div class="close__icon_users">x</div></div>
		</div>
		
		
			<? }?>
		
		<? }else{ ?>
			<div class="images-offonline blue user-sticker<?=$users->id.'-'.$dynamicId;?>" data-userid="<?= $users->id;?>" data-toggle="tooltip" data-id="<?php echo $count;?>" data-placement="bottom" data-username="<?= $users->username;?>" data-userimage="<?= $image ?>" title="<?= $users->fullName;?>" style="position: relative;z-index:<?php echo $count;?>;background-image:url('<?= $image ?>')">
		<div class="delete_user" ><div class="close__icon_users">x</div></div>
		</div>
		
		<? } ?>
		
		
		    
		
	
	
	<? };} ?>
	
	</div>
	<?php Pjax::end(); ?>
	</div>
<?php 
$deleteFolderUsersUrl = Url::to(['folder/delete-users']);

$userJs = <<<JS
$(document).on('click','.select2-selection__choice__remove', function(e){
	e.stopPropagation();
})

function toastFunction(type = 'success',message){
	options = {
		"closeButton": true,
		"debug": false,
		"newestOnTop": true,
		"progressBar": true,
		"positionClass": "toast-top-right",
		"preventDuplicates": true,
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut",
		"tapToDismiss": false
	}
	if(type == 'success'){
		toastr.success(message, "", options);
	}else if(type == 'error'){
		toastr.error(message, "", options);
	}else if(type == 'warning'){
		toastr.warning(message, "", options);
	}
	
}

$(document).on('click','.delete_user', function(e){
	e.stopPropagation();
	\$this  = $(this);
	userId = \$this.parent().data('userid');
	folderId = \$this.parent().parent().parent().parent().parent().parent().parent().data('folderid');
	$.ajax({
              url: '$deleteFolderUsersUrl',
              type: 'POST', 
              data: {
                  folderId: folderId,
                  userId: userId,
                },
              success: function(res){
			  if(res == 1){
			  		console.log('folder deleted');
				   // redirect to folder cabinet
				   toastFunction('success','User has been deleted from folder');
					\$this.parent().remove();
				   console.log(res);
			  }else if(res == 3){
			   // you do not have access to delete this folder
			   toastFunction('warning','sorry you do not have permission to delete this user');
			  }else{
			  // folder could not be deleted cause of unknown reasons, tray again alter;
			  	toastFunction('error','something went wrong, try again ');
			  }
                   
              },
              error: function(res){
                  console.log('Something went wrong');
				  toastFunction('error','something went wrong, try again ');
              }
          });
	
})
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
	
	
	
	
	
	$('body').on('beforeSubmit', '#'+'$type'+'add-new-user'+'$id', function () {
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
               		options = {
		  "closeButton": true,
		  "debug": false,
		  "newestOnTop": true,
		  "progressBar": true,
		  "positionClass": "toast-top-right",
		  "preventDuplicates": true,
		  "showDuration": "300",
		  "hideDuration": "1000",
		  "timeOut": "5000",
		  "extendedTimeOut": "1000",
		  "showEasing": "swing",
		  "hideEasing": "linear",
		  "showMethod": "fadeIn",
		  "hideMethod": "fadeOut",
		  "tapToDismiss": false
		  }
			toastr.success('User has been added to this folder', "", options);
			$.pjax.reload({container:"#user_prefix"+"$pjaxId",async: false});
			
          }
     });
     return false;
});

  
JS;

$this->registerJs($userJs);
?>