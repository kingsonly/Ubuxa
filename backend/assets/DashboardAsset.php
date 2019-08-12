<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css',
        'plugins/bower_components/toast-master/css/jquery.toast.css',
        'plugins/bower_components/morrisjs/morris.css',
        'plugins/bower_components/chartist-js/dist/chartist.min.css',
        'plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css',
        'css/animate.css',
        'css/style.css',
        'css/colors/default.css',
    ];
    public $js = [
		
		'plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js',
		'js/jquery.slimscroll.js',
		'js/waves.js',
		'plugins/bower_components/waypoints/lib/jquery.waypoints.js',
		'plugins/bower_components/counterup/jquery.counterup.min.js',
		'plugins/bower_components/chartist-js/dist/chartist.min.js',
		'plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js',
		'plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js',
		'js/custom.min.js',
		'js/dashboard1.js',
		'plugins/bower_components/toast-master/js/jquery.toast.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

  

 