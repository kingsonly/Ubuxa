<?php
namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class EmojiOneAsset extends AssetBundle
{
	public $sourcePath="@vendor/mervick/emojionearea";
	public $baseUrl = '@web';
	public $css = [
		'dist/emojionearea.min.css',
    ];
	public $js =[
		'dist/emojionearea.min.js',
	];
	public $jsOptions =[
		//'position'=>View::POS_HEAD,
	];
}