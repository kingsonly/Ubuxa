<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'owlcarousel/assets/owl.carousel.min.css',
        'owlcarousel/assets/owl.theme.carousel.min.css',
    ];
    public $js = [
        
        //'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
        'owlcarousel/owl.carousel.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        '\frontend\assets\DragulaAsset',
        '\frontend\assets\CaretAsset',
        '\frontend\assets\AtMentionAsset',
        '\frontend\assets\BootstrapTour',
    ];
}
