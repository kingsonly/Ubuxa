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
</html>
<?php $this->endPage() ?>
