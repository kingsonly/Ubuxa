<?php

namespace frontend\assets;
use yii\web\AssetBundle;
use yii\web\View;

class CalendarAsset extends AssetBundle
{
    public $sourcePath = '@vendor/fullcalendar/fullcalendar';
    public $baseUrl = '@web';
    public $css = [
		'dist/fullcalendar.css',
    ];
    public $js = [
		'dist/fullcalendar.js',
    ];
    public $depends = [
        '\frontend\assets\MomentAsset',
    ];

}




    
    
    
