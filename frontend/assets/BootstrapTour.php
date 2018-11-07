<?php
namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class BootstrapTour extends AssetBundle
{
	public $sourcePath="@vendor/sorich87/bootstrap-tour/build";
	public $baseUrl = '@web';
	public $css = [
		'css/bootstrap-tour.css',
    ];
	public $js=[
		'js/bootstrap-tour.js',
	];
	public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}