<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$inviteLink = Yii::$app->urlManager->createAbsoluteUrl(['site/invite', 'cid' => $user->cid]);
?>
<div class="invite-users">
	<h3>Join <?= Html::encode($user->first_name.' '.$user->last_name) ?> on Ubuxa</h3>

    <p>Hello <?= Html::encode($user->first_name.' '.$user->last_name.' ('.$user->email.')') ?> has invited you to
    	join the Ubuxa workspace. Join now to start collaborating.
    </p>

    <p>Follow the link below to reset your password:</p>

    <p><?= Html::a(Html::encode($inviteLink), $inviteLink) ?></p>
</div>
