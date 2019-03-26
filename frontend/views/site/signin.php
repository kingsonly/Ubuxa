<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Sign into workspace';
?>
<head>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<style>
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,300,700);
body{overflow:hidden;}

.card{
    overflow:hidden;
    font-family:"Open Sans", sans-serif;
    width:620px; 
    height:300px; 
    display:border-box; 
    position:absolute;
    background:#F5F5F5; 
    top:0; left:0; right:0; bottom:0;
    margin:auto;
    box-shadow: 0px 30px 30px -20px rgba(0,0,0,0.2);
    transition:all .4s cubic-bezier(1,.4,.4,1);
    border-radius: 10px;
}
.cards{
    overflow:hidden;
    font-family:"Open Sans", sans-serif;
    width:500px; 
    height:350px; 
    display:border-box; 
    position:absolute;
    background:#F5F5F5; 
    top:0; left:0; right:0; bottom:0;
    margin:auto;
    box-shadow: 0px 30px 30px -20px rgba(0,0,0,0.2);
    transition:all .4s cubic-bezier(1,.4,.4,1);
    border-radius: 10px;
}
.workspace-header{
	text-align: center;
}
#domain{
    padding: 10px;
    margin: 10px auto;
    background-color: #f1f1f1;
    border: 1px solid #ccc;
    width: 50%;
    outline: none;
    font-size: 14px !important;
    font-family: 'Open Sans', sans-serif !important;
    border-radius: 10px;
}
.cont{
	font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; background: #264787; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #264787; display: inline-block;height: 60px;width: 220px;
	    left: 30%;
	    position: absolute;
	    cursor: pointer;
	    border-radius: 10px;
}
.loader-holder{
	width: 40px;
    height: 40px;
    display: none;
}
.myAlert-top{
    position: fixed;
    top: 5px; 
    left:2%;
    width: 96%;
}

.myAlert-bottom{
    position: fixed;
    bottom: 5px;
    left:2%;
    width: 96%;
}

div.fullscreen {
  position: absolute;
  width:100%; 
  height:960px; 
  top: 0; 
  left: 0; 
  background-color: lightblue;
}

.alert{
    display: none;
}
.find{
	position: absolute;
    left: 115px;
    bottom: 20px;
    cursor: pointer;
}
.workspace{
  display: none;
}
.headers{
    color: #1d1c1d;
    font-weight: 800;
    font-size: 28px;
    line-height: 1.2143;
}
.ubuxa-msg{
  text-align: left;
  color:  #676767;
}
.holder{
  margin-left: 25px;
  margin-right: 25px;
  margin-top: 20px;
}
.sign-in{
  text-align: left;
  border-top: 1px solid #ccc;
  margin-top: 26px;
  height: 50px;
  position: relative;
}
.sign-in-text{
  position: absolute;
  top: 19px;
  color: #1d1c1d;
  font-weight: 700;
  float: left;
  font-size: 15px;
  text-overflow: ellipsis;
  left: 45px;
}
.sign-in-icon{
  position: absolute;
  top: 19px;
}
.ubuxa{
  color: #1d1c1d;
  font-weight: 700;
  font-size: 15px;
}
.logo-ubu{
    width: inherit;
    height: 80px;
}
.logo-holder{
  text-align: center;
  margin-top:50px;
}
button:focus {outline:0;}
</style>
<div class="logo-holder"><img class="logo-ubu" src="images/ubu.png"></div>
	<div class="card workspace">
		<div class="workspace-header">
			<h1>Sign in to your workspace</h1>
			<p>Enter your workspace’s <strong>URL</strong>.</p>
			<p class="">
				<input type="text" name="domain" id="domain" value="" placeholder="workspace-url" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
				<span class="domain ubuxa">.ubuxa.net</span>
			</p>
			<button class="cont">Continue <img src="images/Spinner2.gif" class="loader-holder"></button>
			<a href="<?= Url::to(['site/find-workspace']);?>" class="find">Can't remember your workspace? Find your workspace.</a>
		</div> 
	</div>
<div class="myAlert-top alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>We couldn't find the workspace.</strong>
</div>

<div class="cards">
  <div class="workspace-header">
    <h1 class="headers">Start with a workspace</h1>
    <div class="holder">
      <p class="ubuxa-msg">Sign in to your Ubuxa workspace or signup to join Ubuxa</p>
      <a href="#workspace" class="get-workspace">
        <div class="sign-in">
          <i class="fas fa-sign-in-alt fa-2x sign-in-icon"></i>
          <span class="sign-in-text"> Sign in to your workspace</span>
        </div> 
      </a>
      <a href="<?= Url::to(['site/customersignup','plan_id' => 1]);?>">
        <div class="sign-in">
          <i class="fas fa-user-plus fa-2x sign-in-icon"></i>
          <span class="sign-in-text"> Sign up to join Ubuxa</span>
        </div>
     </a>
    </div>
  </div>
</div>

<?php 
$loginUrl = 'ubuxa.net';
$signinUrl = Url::to(['site/signin']);
$indexJs = <<<JS
$('.cont').on('click', function(){
	$('.loader-holder').show();
	var domain = $('#domain').val();
	_CheckDomain(domain);
})

$('.get-workspace').on('click', function(e){
  $('.cards').hide()
  $('.card').show()
})

$('#domain').bind("keyup keypress", function(e) {
  var domain = $('#domain').val();
  var code = e.keyCode || e.which; 
  if (code  == 13) {    
      if($(this).val()==''){
          e.preventDefault();
          return false;
      }
      _CheckDomain(domain);
  }
});

function myAlertTop(){
  $(".myAlert-top").show();
  setTimeout(function(){
    $(".myAlert-top").hide(); 
  }, 3000);
}

$(document).ready(function(){
    $('.cont').attr('disabled',true);
    $('#domain').keyup(function(){
        if($(this).val().length !=0){
            $('.cont').attr('disabled', false);            
        }
        else{
            $('.cont').attr('disabled',true);
        }
    })
});

function _CheckDomain(domain){
  $.ajax({
      url: '$signinUrl',
      type: 'POST',
      async: false, 
      data: {
          domain: domain,
        },
      success: function(response){
      		$('.loader-holder').hide();
      		if(response == 1){
      			var result = domain +'.'+ '$loginUrl';
				window.location.replace("http://"+result)
      		}else{
      			myAlertTop();
      		}
           console.log(response);
      },
      error: function(response){
          console.log(response);
      }
  });
}
JS;
$this->registerJs($indexJs);
?>