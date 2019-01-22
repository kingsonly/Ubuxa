<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

use app\assets\LoginAsset;

LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	<? $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Yii::$app->settingscomponent->boffinsFavIcon()]); ?>
	
</head>

<body class="hold-transition login-page">
<?php $this->beginBody() ?>

<div class="wrap">
    

    <div class="container">
        
        <?= $content ?>
    </div>
</div>



<?php $this->endBody() ?>
</body>
<script src='//cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js'></script>

<script>
var socket = io.connect('//127.0.0.1:3000');

socket.on('connect', function () {
    console.log('connected');
	console.log('A user connected');
	socket.on('message', function(data){
		
	});
    

    socket.on('disconnect', function () {
        console.log('disconnected');
		
    });
});
</script>
</html>
<?php $this->endPage() ?>
