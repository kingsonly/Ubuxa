<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<style>
.card{
    overflow:hidden;
    font-family:"Open Sans", sans-serif;
    width:500px; 
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
.workspace-header{
	text-align: center;
}
.headers{
	color: #1d1c1d;
    font-weight: 800;
    font-size: 28px;
    line-height: 1.2143;
}
.find-text{
	font-size: 15px;
    color: #615d5d;
}
.user-email{
	font-size: 1.25rem;
    line-height: normal;
    padding: .75rem;
    border: 1px solid #868686;
    border-radius: .25rem;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    outline: 0;
    color: #1d1c1d;
    width: 100%;
    max-width: 100%;
    margin: 0 0 .5rem;
    font-variant-ligatures: none;
    -webkit-transition: box-shadow 70ms ease-out,border-color 70ms ease-out;
    -moz-transition: box-shadow 70ms ease-out,border-color 70ms ease-out;
    transition: box-shadow 70ms ease-out,border-color 70ms ease-out;
    box-shadow: none;
    height: auto;
}
#user-email{
    padding: 10px;
    margin: 10px auto;
    background-color: #f1f1f1;
    border: 1px solid #ccc;
    width: 65%;
    outline: none;
    font-size: 14px !important;
    font-family: 'Open Sans', sans-serif !important;
    border-radius: 10px;
}
button:focus {outline:0;}
.send{
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
.success-message {
  text-align: center;
  max-width: 500px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.success-message__icon {
  max-width: 75px;
}

.success-message__title {
  color: #3DC480;
  transform: translateY(25px);
  opacity: 0;
  transition: all 200ms ease;
}
.active .success-message__title {
  transform: translateY(0);
  opacity: 1;
}

.success-message__content {
  color: #B8BABB;
  transform: translateY(25px);
  opacity: 0;
  transition: all 200ms ease;
  transition-delay: 50ms;
}
.active .success-message__content {
  transform: translateY(0);
  opacity: 1;
}

.icon-checkmark circle {
  fill: #3DC480;
  transform-origin: 50% 50%;
  transform: scale(0);
  transition: transform 200ms cubic-bezier(0.22, 0.96, 0.38, 0.98);
}
.icon-checkmark path {
  transition: stroke-dashoffset 350ms ease;
  transition-delay: 100ms;
}
.active .icon-checkmark circle {
  transform: scale(1);
}
.success-text{
	display: none;
}
.none{
	margin-top: -20px;
    color: #d65f5f;
    display: none;
}
</style>

<div class="card">
	<div class="workspace-header">
		<div class="content">
			<h1 class="headers">Let's find your workspace</h1>
			<p class="find-text">We’ll send you an email containing your ubuxa workspaces.</p>
			<p><input type="email" name="email" id="user-email" value="" data-lpignore="true" placeholder="Enter your email" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"></p>
			<button class="send">Send <img src="images/Spinner2.gif" class="loader-holder"></button>
		</div>
		<div class="success-text">
			<div class="success-message">
			    <svg viewBox="0 0 76 76" class="success-message__icon icon-checkmark">
			        <circle cx="38" cy="38" r="36"/>
			        <path fill="none" stroke="#FFFFFF" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M17.7,40.9l10.9,10.9l28.7-28.7"/>
			    </svg>
			    <h1 class="success-message__title">Email Sent</h1>
			    <div class="success-message__content">
			        <p>Please check your email to see your workspaces.</p>
			    </div>
			</div>
		</div>
		<p class="none">We can't find your email. <a href="<?= Url::to(['site/customersignup','plan_id' => 1]);?>">Sign Up?</a></p>
	</div>
</div>


<?php 
$findDomain = Url::to(['site/find-workspace']);
$indexJs = <<<JS
$('.send').on('click', function(){
	$('.loader-holder').show();
	var email = $('#user-email').val();
	_FindWorkspace(email);
})

function _FindWorkspace(email){
  $.ajax({
      url: '$findDomain',
      type: 'POST',
      async: false, 
      data: {
          email: email,
        },
      success: function(response){
      		$('.loader-holder').hide();
      		$('.none').fadeOut();
      		if(response == 1){
      			$('.content').fadeOut();
      			$('.success-text').fadeIn();
      			function PathLoader(el) {
					this.el = el;
				    this.strokeLength = el.getTotalLength();
					
				    // set dash offset to 0
				    this.el.style.strokeDasharray =
				    this.el.style.strokeDashoffset = this.strokeLength;
				}

				PathLoader.prototype._draw = function (val) {
				    this.el.style.strokeDashoffset = this.strokeLength * (1 - val);
				}

				PathLoader.prototype.setProgress = function (val, cb) {
					this._draw(val);
				    if(cb && typeof cb === 'function') cb();
				}

				PathLoader.prototype.setProgressFn = function (fn) {
					if(typeof fn === 'function') fn(this);
				}

				var body = document.body,
				    svg = document.querySelector('svg path');

				if(svg !== null) {
				    svg = new PathLoader(svg);
				    
				    setTimeout(function () {
				        document.body.classList.add('active');
				        svg.setProgress(1);
				    }, 200);
				}
      		}else{
      			$('.none').fadeIn();
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