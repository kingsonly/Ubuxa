<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="new-reminder">
	<h3>Ubuxa Workspaces</h3>

    <p>
		<strong>
			<p>Click link below to open your workspace.</p>
			<?php foreach ($domain as $name) { ?>
				<a href="<?=$name;?>.ubuxa.net"><?=$name;?></a>
			<?php }?>
		</strong>
    </p>

    <p><?//= Html::a('Click on link to complete your registration', $link); ?></p>
</div>
