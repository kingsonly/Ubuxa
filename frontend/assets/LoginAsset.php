<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        //'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
        //'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
        'css/AdminLTE.min.css',
        'css/_all-skins.min.css',
        'css/blue.css',
        'css/morris.css',
        'css/jquery-jvectormap-1.2.2.css',
        'css/datepicker3.css',
        'css/daterangepicker.css',
        '',
        'css/bootstrap3-wysihtml5.min.css',
    ];
      
    public $js = [
        //'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js',
        //'bootstrap.min.js',
        //'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
        //'morris.min.js',
        //'jquery.sparkline.min.js',
        //'icheck.min.js',
        //'jquery-jvectormap-world-mill-en.js',
        //'jquery.knob.js',
        //'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js',
        //'daterangepicker.js',
        //'bootstrap-datepicker.js',
        //'bootstrap3-wysihtml5.all.min.js',
        //'jquery.slimscroll.min.js',
        //'fastclick.js',
        //'jquery-2.2.3.min.js',
        //'dashboard.js',
        //'demo.js',
    ];
	
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

