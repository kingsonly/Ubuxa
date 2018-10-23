<?
use yii\helpers\Url;
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

	#folderusers{
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
<div id="folderusers">
	<div id="invitenewuser">AUTHORIZED USERS</div>
	
	
	<div class="dropdown">
		<span id="plus-button" class="dropdown-toggle" id="dropdownMenuButtons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-plus-sign" data-toggle="tooltip-user" data-placement="bottom" title="add new user"></i></span>
	
	
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtons">
                          <li id="" class="">Create Invoice</li>
							<hr>
                          <li>Create Project</li>
							<hr>
                          <li>Create Payment</li>
							<hr>
                          <li>Create Order</li>
                          
                        </div>
                        </div>
	
	
	
	<div class="user-image">
	<?php $count= count($attributues); ?>
<?php foreach($attributues as $users){ 
	$image = !empty($users["image"])?$users["image"]:'default-user.png';
	$count--;
	?>
		
		    <div class="images blue" data-toggle="tooltip" data-id="<?php echo $count;?>" data-placement="bottom" title="<?= $users['username'];?>" style="position: relative;z-index:<?php echo $count;?>;background-image:url('<?= Url::to('@web/images/users/'.$image); ?>')"></div>
		
	
	
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
JS;

$this->registerJs($userJs);
?>