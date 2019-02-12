<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use frontend\models\Edocument;


// Task widget is a widget which represent a section on the folder  dashboard which is responsible for the holding of users task and reminder
class EdocumentWidget extends Widget
{
    public $edocument;
    public $docsize; //set width of widget
    public $target; //
    public $attachIcon; //attach widgte icon
    public $textPadding; //adjust text pading
    public $reference; //get drop target location
    public $referenceID; //get drop target location
    public $iconPadding; //padding for icon
    public $tasklist; //needed to hide tasklist on board
   

    public function init()
    {
        parent::init();
    }

    public function run()
    {
         // Register AssetBundle
        return $this->render('edocument', [
            'edocument' => $this->edocument,
            'docsize' => $this->docsize,
            'target' => $this->target,
            'attachIcon' => $this->attachIcon,
            'textPadding' => $this->textPadding,
            'reference' => $this->reference,
            'referenceID' => $this->referenceID,
            'iconPadding' => $this->iconPadding,
            'tasklist' => $this->tasklist,
            'model' => new Edocument(),
        	]);
    }
}
?>