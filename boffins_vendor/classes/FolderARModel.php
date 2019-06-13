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
use boffins_vendor\behaviors\FolderBehavior;
use yii\db\ActiveQuery;
use boffins_vendor\classes\StandardQuery;
use models\FolderComponent;
use models\UserDb;
use frontend\models\Folder;
use frontend\models\Clip;
//use app\models\ComponentManager;
use boffins_vendor\classes\StandardFolderQuery;
use boffins_vendor\classes\BoffinsArRootModel;
use boffins_vendor\classes\models\{TenantSpecific, TrackDeleteUpdateInterface, ClipableInterface};


/**
 * This ia an ActiveRecord class strictly for subcomponents of a folder. 
 *
 */

class FolderARModel extends BoffinsArRootModel implements TenantSpecific, TrackDeleteUpdateInterface, ClipableInterface
{
	
	
	public $defaltBehaviour;

	protected $_users = [];
		
	const DEFAULT_PRIVATE_FOLDER_STATUS = 0; // by default when a folder is not private its = 0
	
	const DEFAULT_FOLDER_PARENT_STATUS = 0; // by default when a folder has no parent its  = 0 meaning ints not a child folder
	
	const DEFAULT_AJAX_SUCCESS_STATUS = 1; // when an ajax call is successful return 1
	
	const DEFAULT_AJAX_ERROR_STATUS = 0; // when an ajax call is not successful return 0
	
	public function init(){
		parent::init();
		$this->attachBehavior("FolderBehavior", [
					'class' => FolderBehavior::className(),
					
				]);
	}
	
	public function containsFolderTree($tree=[], $parent) 
	{
		if ( $parent == 0 ) {
			return $tree;
		}else{
			
			$getParentDetails = Folder::find()->select(['parent_id','id','title'])->where(['id'=> $parent])->one();
			if(!empty($getParentDetails)){
				array_push($tree,$getParentDetails);
			} else{
				return $tree;
			}
			
		}
		//return $getParentDetails['parent_id'];
		return $getParentDetails->parent_id > 0 ? $this->containsFolderTree($tree,$getParentDetails->parent_id):$tree;
		
	}
	
	/***
	 * Overriding base active record to use StandardQuery Active Query subclass
	 * StandardQuery only finds items that are not marked for delete
	 * To find items deleted, use deleted()
	 */
	public static function find() 
	{
		Yii::info("Using StandardFolderQuery class to perform queries in " . static::class, __METHOD__ );
		return new StandardFolderQuery(get_called_class());
	}
	
	
	

	
	public function specificClipsWithLimitAndOffset($limit=4,$offset=0,$ownerTypeId=2,$barId = 0)
    {
        return Clip::find()->select(['owner_id'])->where(['bar_id' => $barId])->andWhere(['owner_type_id' => $ownerTypeId])->asArray()->limit($limit)->offset($offset)->all();
		
		
    }
	
	/**
	 *  @brief {@inheritdoc}
	 */
	protected function subscribeInstanceOnInsert()
	{
		return true;
	}
	
	
}