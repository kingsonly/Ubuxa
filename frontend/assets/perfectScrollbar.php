<?php
namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class perfectScrollbar extends AssetBundle
{
	public $sourcePath="@npm/perfect-scrollbar";
	public $baseUrl = '@web';
	public $css = [
		'css/perfect-scrollbar.css',
    ];
	public $js =[
		'dist/perfect-scrollbar.js',
	];
	public $jsOptions =[
		//'position'=>View::POS_HEAD,
	];
}