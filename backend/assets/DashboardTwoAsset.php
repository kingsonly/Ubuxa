<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class DashboardTwoAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "dashboardtwo/assets/libs/flot/css/float-chart.css",
    	"dashboardtwo/dist/css/style.min.css",
     	"bsb/assets/css/font-awesome.css",
      	"bsb/assets/css/custom.css"
    ];
    public $js = [
		
		
    	"dashboardtwo/assets/libs/popper.js/dist/umd/popper.min.js",
		"dashboardtwo/assets/libs/bootstrap/dist/js/bootstrap.min.js",
   		"dashboardtwo/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js",
		"dashboardtwo/assets/extra-libs/sparkline/sparkline.js",
		"dashboardtwo/dist/js/waves.js",
		"dashboardtwo/dist/js/sidebarmenu.js",
    	"dashboardtwo/dist/js/custom.min.js",
    	"dashboardtwo/dist/js/pages/dashboards/dashboard1.js",
		"dashboardtwo/assets/libs/flot/excanvas.js",
		"dashboardtwo/assets/libs/flot/jquery.flot.js",
		"dashboardtwo/assets/libs/flot/jquery.flot.pie.js",
		"dashboardtwo/assets/libs/flot/jquery.flot.time.js",
		"dashboardtwo/assets/libs/flot/jquery.flot.stack.js",
		"dashboardtwo/assets/libs/flot/jquery.flot.crosshair.js",
		"dashboardtwo/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js",
		"dashboardtwo/dist/js/pages/chart/chart-page-init.js",
		"bsb/assets/js/custom.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

  

 