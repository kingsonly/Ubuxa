<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;

class MenuWidget extends Widget
{
    public $icon;  
    
    /* 
    * menu defaulticon an array off all presently avalable menu icon
    */
    private $defaultIcon = [
            'folder'=>'fa-folder',
            'project'=>'fa-briefcase',
            'invoice'=>'fa-print',
            'order'=>'fa-first-order',
            'payment'=>'fa-credit-card-alt',
            'receivedpurchaseorder'=>'fa-quote-left',
            'correspondence'=>'fa-quote-left'];
    
    /* 
    * menu $privateIcon an array off all icons merged in the init method
    */
    
    private $privateIcon;

    public $componentMenuSetting;// used to add more menu to the list of menu

    // defaultComponentMenu is an array of all presently available menu by default
    private $defaultComponentMenu =[
            'folder',
            'project',
            'invoice',
            'order',
            'payment',
            'receivedpurchaseorder',
            'correspondence'
        ];

    private $componentMenu;// a merger of custom and default menu

    public function init()
    {
        parent::init();
        if(empty($this->componentMenuSetting)){
            $this->componentMenu = $this->defaultComponentMenu;
        } else {
            $this->componentMenu = array_merge($this->defaultComponentMenu,$this->componentMenuSetting);
        }
        if(empty($this->icon)){
            $this->privateIcon = $this->defaultIcon;
        } else {
            $this->privateIcon = array_merge($this->defaultIcon,$this->icon);
        }
    }

    public function run()
    {   
        return $this->loopMenu();
         // Register AssetBundle
        //MenuWidgetAsset::register($this->getView());
        //return $this->render('menu');
    }

    private function loopMenu(){
        // Register AssetBundle
        MenuWidgetAsset::register($this->getView());
        return $this->render('menu',[
            'componentMenu' => $this->componentMenu,
            'icons' => $this->privateIcon,
        ]);
    
    }
}
?>

