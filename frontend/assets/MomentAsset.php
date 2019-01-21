<?php

namespace frontend\assets;
use yii\web\AssetBundle;
use yii\web\View;

class MomentAsset extends AssetBundle
{
    public $sourcePath = '@vendor/moment/moment';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
		'moment.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        '\frontend\assets\JqueryUiAsset',
    ];

}




    
    
    
