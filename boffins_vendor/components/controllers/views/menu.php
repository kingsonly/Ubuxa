<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="side_menu">
	<div class="burger_box">
		<div class="menu-icon-container">
			<a href="#" class="menu-icon js-menu_toggle closed">
				<span class="menu-icon_box">
					<span class="menu-icon_line menu-icon_line--1"></span>
					<span class="menu-icon_line menu-icon_line--2"></span>
					<span class="menu-icon_line menu-icon_line--3"></span>
				</span>
			</a>
		</div>
	</div>
	<div class="container">
		<h2 class="menu_title">UBUXA</h2>
		<div class="tabs">
		  <div class="tab-2">
		    <label for="tab2-1">One</label>
		    <input id="tab2-1" name="tabs-two" type="radio" checked="checked">
				<div>
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
			    </div>
			    <div class="tab-2">
				    <label for="tab2-2">Two</label>
				    <input id="tab2-2" name="tabs-two" type="radio">
			    	<div>
			    	<ul class="list_load">
				    	<li class="list_item"><a href="#">List Item 01</a></li>
						<li class="list_item"><a href="#">List Item 02</a></li>
						<li class="list_item"><a href="#">List Item 03</a></li>
						<li class="list_item"><a href="#">List Item 04</a></li>
						<li class="list_item"><a href="#">List Item 05</a></li>
						<li class="list_item"><a href="#">List Item 06</a></li>
						<li class="list_item"><a href="#">List Item 07</a></li>
						<li class="list_item"><a href="#">List Item 08</a></li>
					</ul>
			    </div>
			</div>
		</div>
	</div>
</div>