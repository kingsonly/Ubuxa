<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\UserDb;
?>
<div class="side_menu">
	<div class="burger_box">
		<div class="menu-icon-container">
			<a href="#" class="menu-icon js-menu_toggle closed">
				<span class="menu-icon_box">
					<img src="images/ubuxalogo.png" class="ubuxalogo"/>
				</span>
			</a>
		</div>
	</div>
	<div class="container">
		<div class="top-sidebar">
			<?php if(!empty(yii::$app->user->identity->profile_image)){ ?>
				<div class="side-images" style="position: relative;z-index:1000;background-image:url('<?= Url::to('images/users/'.yii::$app->user->identity->profile_image); ?>')"></div>
			<?php }else{?>
				<div class="side-images" style="position: relative;z-index:1000;background-image:url('<?= Url::to('@web/images/users/default-user.png'); ?>')"></div>
			<?php }?>
			<div class="client-name">
				<span class="first-name"><?= yii::$app->user->identity->fullName; ?></span>
				<div><a class="profile-link" href="#">View profile</a></div>
			</div>
		</div>
			<div class="wrap">
  
  <ul class="tabs group">
    <li><a class="active" href="#/one"> One</a></li>
    <li><a href="#/two">Two</a></li>
    <li><a href="#/three">Three</a></li>
  </ul>
  
  <div id="content">
    <div id="one">
    	<ul class="list_load">
			    	<?php
			    		foreach($componentMenu as $k => $v){
			    			$url = $v.'/index';
							echo Html::tag('li',Html::a(Html::tag('i', '', ['class' => 'fa '.$icons[$v],'title' => $v]).'  '. Html::tag('span', ucfirst($v), 
								['class' => '','title' => $v]), [$url], ['class' => '','title' => 'Open'.$v,]),
								['class' => [(Yii::$app->controller->id == $v) ? 'active' : 'false', 'list_item']]);
			    		}
			    	?>
		</ul>
    </div>
<?php if (isset($this->blocks['sidebar'])){ ?>
            <?= $this->blocks['sidebar'] ?>
<?php }else{ ?>
      <div id="two">
    	<ul class="list_load">
    		<li class="list_item"><a href="#">List Item 01</a></li>
			<li class="list_item"><a href="#">List Item 02</a></li>
			<li class="list_item"><a href="#">List Item 03</a></li>
    	</ul>
    </div>
    <div id="three">
    	<ul class="list_load">
			<li class="list_item"><a href="#">Settings</a></li>
			<li class="list_item"><a href="<?= Url::to(['site/logout'])?>">Logout</a></li>
			
		</ul>
    </div>
<?php } ?>
  </div>
  
</div>
</div>