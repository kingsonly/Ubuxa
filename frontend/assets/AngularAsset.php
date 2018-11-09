<?php
namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AngularAsset extends AssetBundle
{
	public $sourcePath="@bower";
	public $css = [
		'angular-xeditable/dist/css/xeditable.css',
    ];
	public $js        =[
		'angular/angular.js',
		//'angular-route/angular-route.js',
		'angular-xeditable/dist/js/xeditable.js',
		
	];
	public $jsOptions =[
		//'position'=>View::POS_HEAD,
	];
}