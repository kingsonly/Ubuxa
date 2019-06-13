<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;

class ErrorPageWidget extends Widget
{
	public $content;
	public $url;
	public $contentHeader;
	public $errorHeader;
	public $button;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
         // Register AssetBundle
        return $this->render('errorpage',[
        	'content' => $this->content,
        	'url' => $this->url,
        	'contentHeader' => $this->contentHeader,
        	'errorHeader' => $this->errorHeader,
        	'button' => $this->button,
        ]);
    }
}
?>