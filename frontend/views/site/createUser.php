<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $userForm app\models\UserDb */

$this->params['breadcrumbs'][] = ['label' => 'users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('signup', [
        'userForm' => $userForm,
		'action' => $action,
		'customer' => $customer,
		'userExists' => $userExists,
    ]) ?>

</div>
