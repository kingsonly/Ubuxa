<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle; 

class IndexDashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        //'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
        //'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
        'css/AdminLTE.css',
        'css/_all-skins.min.css',
        'css/blue.css',
        'css/morris.css',
        'css/jquery-jvectormap-1.2.2.css',
        'css/datepicker3.css',
        'css/daterangepicker.css',
        'css/datatables/dataTables.bootstrap.css',
        'css/bootstrap3-wysihtml5.min.css',
		'//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css',
        'css/fontawesome/css/font-awesome.css',
        'css/fontawesome/css/main.css',
        'css/fontawesome/css/font-awesome.min.css',
    ];
    public $js = [
        
		
		'js/jquery.sticky-kit.min.js',
        'js/datatables/jquery.dataTables.min.js',
        'js/datatables/dataTables.bootstrap.min.js',
        //'js/bootstrap.min.js',
        //'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
        'js/morris.min.js',
        'js/jquery.flip.min.js',
        //'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js',
        'js/app.js',
        '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js',
        'js/Chart.min.js',
        'js/dashboard.js',
		  
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}




    
    
    
