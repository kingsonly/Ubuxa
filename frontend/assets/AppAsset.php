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
        'css/spectrum.css',
        'css/bootstrap-suggest.css',
    ];
    public $js = [
        'js/spectrum.js',
        'js/bootstrap-suggest.js',
        '//unpkg.com/jscroll/dist/jquery.jscroll.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'frontend\assets\RemarkAsset',
    ];
}
