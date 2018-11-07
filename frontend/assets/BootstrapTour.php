<?php
namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class BootstrapTour extends AssetBundle
{
	public $sourcePath="@npm/bootstrap-tour";
	public $baseUrl = '@web';
	public $css = [
		'build/css/bootstrap-tour.min.css',
    ];
	public $js        =[
		'build/js/bootstrap-tour.js',
	];
	public $jsOptions =[
		'position'=>View::POS_HEAD,
	];
}