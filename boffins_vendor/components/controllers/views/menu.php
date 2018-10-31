<?php
use yii\helpers\Html;
use yii\helpers\Url;
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
		<h2 class="menu_title">UBUXA</h2>
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
<?php if (isset($this->blocks['sidebar'])): ?>
            <?= $this->blocks['sidebar'] ?>
          <?php endif; ?>
  </div>
  
</div>
</div>