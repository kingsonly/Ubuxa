<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="new-reminder">
	<h3>Ubuxa Reminder</h3>

    <p>
		<strong>
			Reminder for your task <?=$taskTitle;?>.
			Note: <?= $message; ?>	
		</strong>
    </p>

    <p><?//= Html::a('Click on link to complete your registration', $link); ?></p>
</div>
