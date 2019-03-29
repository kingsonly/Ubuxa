<?php
namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class EmojiPickerAsset extends AssetBundle
{
	public $sourcePath="@npm/onesignal-emoji-picker";
	public $baseUrl = '@web';
	public $css = [
		'lib/css/emoji.css',
		'lib/css/nanoscroller.css',
    ];
	public $js =[
		'lib/js/nanoscroller.min.js',
		'lib/js/tether.min.js',
		'lib/js/config.js',
		'lib/js/util.js',
		'lib/js/jquery.emojiarea.js',
		'lib/js/emoji-picker.js',
	];
	public $jsOptions =[
		'position'=>View::POS_END,
	];
}