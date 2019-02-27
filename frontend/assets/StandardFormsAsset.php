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
class StandardFormsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		//FOR ADMINLTE TEMPLATE
        'css/bootstrap.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
        //'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
        //'css/AdminLTE.min.css',
		'css/AdminLTE.css',
		'css/chat.css',
        'css/_all-skins.min.css',
        'css/blue.css',
        'css/morris.css',
        'css/jquery-jvectormap-1.2.2.css',
        
        'css/datatables/dataTables.bootstrap.css',
        'css/bootstrap3-wysihtml5.min.css',
		
		//BOFFINS INCLUDED css
		'css/forms/simple.css',
        'css/fontawesome/css/font-awesome.css',
        'owlcarousel/assets/owl.carousel.min.css',
        'owlcarousel/assets/owl.theme.default.min.css',
		
        //'css/fontawesome/css/font-awesome.min.css',
        'css/hover.css',
		'//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css',
		'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.9/css/fileinput.min.css',
		'css/addons/pager/jquery.tablesorter.pager.css',
		
    ];
    public $js = [
		'js/jquery.sticky-kit.min.js',
        'js/morris.min.js',
        'js/app.min.js',
        'js/datatables/jquery.dataTables.min.js',
        'js/datatables/dataTables.bootstrap.min.js',
        'js/Chart.min.js',
        //BOFFINS INCLUDED JS
		'js/jquery.event.drag.min.js',
		'js/jquery.mousewheel.min.js',
		'js/jquery.newstape.js',
		'assets/82fd07a/jquery-ui.js',
		'js/dashboard.js',
		'js/jquery.flip.min.js',
		'js/script.js',
		'js/feedify.min.js',
		'//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js',
		'owlcarousel/owl.carousel.js',
		'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.9/js/plugins/piexif.min.js',
		'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.9/js/fileinput.min.js',
		'js/jquery.tablesorter.min.js',
		'js/jquery.tablesorter.widgets.min.js',
		'js/addons/pager/jquery.tablesorter.pager.js',
		'https://cdn.webrtc-experiment.com/socket.io.js',
		'https://webrtc.github.io/adapter/adapter-latest.js',
		'js/socketio.js',
		//'js/chat-client-script.js',
		'js/moment.min.js',
		'js/jquery.cookie.js',
		
		///'js/dragables.js'
		
		
		
		
		
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}




    
    
    
