<?php
/**
 * @copyright Copyright (c) 2017 Tycol Main (By Epsolun Ltd)
 */

namespace boffins_vendor\classes;

use Yii;
use yii\base\Behavior;
use yii\behaviors\AttributeBehavior;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use boffins_vendor\behaviors\DeleteUpdateBehavior;
use boffins_vendor\behaviors\DateBehavior;
use boffins_vendor\behaviors\ComponentsBehavior;
use yii\db\ActiveQuery;
use boffins_vendor\classes\StandardQuery;
use models\FolderComponent;
use models\UserDb;
use frontend\models\Folder;
use frontend\models\Clip;
//use app\models\ComponentManager;
use boffins_vendor\classes\StandardComponentQuery;
use boffins_vendor\classes\BoffinsArRootModel;
use boffins_vendor\classes\models\{StandardTenantQuery, TenantSpecific, TrackDeleteUpdateInterface, ClipableInterface};



/**
 * This ia an ActiveRecord class strictly for subcomponents of a folder. 
 *
 */

class ComponentARModel extends BoffinsArRootModel implements TenantSpecific, TrackDeleteUpdateInterface, ClipableInterface
{
	
	public function init(){
		parent::init();
		$this->attachBehavior("ComponentsBehavior", [
					'class' => ComponentsBehavior::className(),
					
				]);
	}
	
	
	public function myBehaviors() 
	{
		
		return [
			
			'ComponentsBehavior' => ComponentsBehavior::className(),// make use of component behaviour
		];
	}
	
	
	/***
	 * Overriding base active record to use StandardQuery Active Query subclass
	 * StandardQuery only finds items that are not marked for delete
	 * To find items deleted, use deleted()
	 */
	public static function find() 
	{
		return new StandardComponentQuery(get_called_class());
	}
	
	
	
}