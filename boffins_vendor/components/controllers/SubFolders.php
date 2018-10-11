<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;

class SubFolders extends Widget
{

    public function init()
    {
        parent::init();
    }
	public $folderModel;
    public function run()
    {
         // Register AssetBundle
        return $this->render('subfolders',[
			'folderModel' => $this->folderModel,
		]);
    }
}
?>