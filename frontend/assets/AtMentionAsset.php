<?php
namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AtMentionAsset extends AssetBundle
{
	public $sourcePath="@npm/at.js";
	public $baseUrl = '@web';
	public $css = [
		'dist/css/jquery.atwho.css',
    ];
	public $js        =[
		'dist/js/jquery.atwho.js',
	];
	public $depends = [
        '\frontend\assets\CaretAsset',
    ];
}