<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $userForm app\models\UserDb */

$this->params['breadcrumbs'][] = ['label' => 'customer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('customersignup', [
        'customerForm' => $customerForm,
		'action' => $action,
		'tenantEntity' => $tenantEntity,
		'tenantCorporation' => $tenantCorporation,
		'tenantPerson' => $tenantPerson, 
    ]) ?>

</div>
