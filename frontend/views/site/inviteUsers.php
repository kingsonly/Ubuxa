<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $userForm app\models\UserDb */

$this->title = 'Invite Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('inviteform', [
        'model' => $model,
    ]) ?>

</div>
