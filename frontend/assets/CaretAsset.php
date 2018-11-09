<?php
namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class CaretAsset extends AssetBundle
{
	public $sourcePath="@npm/jquery.caret";
	public $baseUrl = '@web';
	public $css = [

    ];
	public $js        =[
		'dist/jquery.caret.js',
	];
	public $jsOptions =[
		//'position'=>View::POS_HEAD,
	];
}