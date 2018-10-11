<?php

namespace boffins_vendor\components\controllers;

use yii\web\AssetBundle;

class MenuWidgetAsset extends AssetBundle
{
    public $js = [
        'js/MenuAsset.js'
    ];

    public $css = [
         // CDN lib
        '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',
        'css/MenuAsset.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public function init()
    {
        // Tell AssetBundle where the assets files are
        $this->sourcePath = __DIR__ . "/assets";
        parent::init();
    }
}