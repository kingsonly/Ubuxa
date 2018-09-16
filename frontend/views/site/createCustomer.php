<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $userForm app\models\UserDb */

$this->title = 'Create your Account';
$this->params['breadcrumbs'][] = ['label' => 'customer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('customersignup', [
        'customerForm' => $customerForm,
		'action' => $action,
    ]) ?>

</div>
