<?php

namespace frontend\assets;
use yii\web\AssetBundle;
use yii\web\View;

class JqueryUiAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/jquery-ui';
    public $baseUrl = '@web';
    public $css = [
    	'//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css',
    ];
    public $js = [
		'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js',
    ];

}




    
    
    
