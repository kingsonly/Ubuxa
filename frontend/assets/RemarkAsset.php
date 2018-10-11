<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class RemarkAsset extends AssetBundle
{
    public $basePath = '@npm/trumbowyg';
    public $baseUrl = '@web';
    public $css = [
		
		
    ];
    public $js = [
		
		'dist/trumbowyg.min.js',
		
			
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
}




    
    
    
