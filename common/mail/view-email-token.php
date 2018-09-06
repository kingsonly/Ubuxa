<?php
use yii\helpers\Html;
use yii\helpers\Url;


?>
<h2>This is your token: </h2>
<h1><p style="text-align:center;" ><? echo $token ?></p></h1>
<?= Html::a('Login', Url::home('http:')) ?>