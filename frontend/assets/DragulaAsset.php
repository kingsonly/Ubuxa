<?php
namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class DragulaAsset extends AssetBundle
{
	public $sourcePath="@npm/dragula";
	public $baseUrl = '@web';
	public $css = [
		'dist/dragula.min.css',
    ];
	public $js =[
		'dist/dragula.min.js',
	];
	public $jsOptions =[
		//'position'=>View::POS_HEAD,
	];
}