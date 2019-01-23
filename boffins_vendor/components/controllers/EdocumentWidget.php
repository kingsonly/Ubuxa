<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use frontend\models\Edocument;


// Task widget is a widget which represent a section on the folder  dashboard which is responsible for the holding of users task and reminder
class EdocumentWidget extends Widget
{
    public $edocument;
    public $docsize;
    public $target;
    public $attachIcon;
    public $textPadding;
    public $reference;
    public $referenceID;
    public $location;
    public $iconPadding;
    public $tasklist;
   

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
            //'location' => !empty($this->location)?$this->location:'task',
        	]);
    }
}
?>