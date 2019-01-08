<?php
namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class DropzoneAsset extends AssetBundle
{
	public $sourcePath="@vendor/dropzone";
	public $baseUrl = '@web';
	public $js=[
		'dropzone.js',
	];
}