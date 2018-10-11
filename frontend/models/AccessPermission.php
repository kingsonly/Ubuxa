<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%access_permission}}".
 *
 * @property string $action
 * @property integer $access_value
 * @property string $type
 */
class AccessPermission extends \yii\db\ActiveRecord
{
	
	const AP_ACTION = 'action';
	const AP_OTHER = 'other';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%access_permission}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action', 'access_value', 'type'], 'required'],
            [['access_value'], 'integer'],
            [['type'], 'string'],
            [['action'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'action' => Yii::t('AccessPermission', 'Action'),
            'access_value' => Yii::t('AccessPermission', 'Access Value'),
            'type' => Yii::t('AccessPermission', 'Type'),
        ];
    }
	
	/**
	 * returns a list of 'controlled' actions for which permissions need to be granted. 
	 * @return array
	 */
	public static function allActions() {
		$actions = [];
		foreach ( self::findAll(['type' => self::AP_ACTION]) as $a ) {
			$actions[] = $a->action;
		}
		return $actions;
	}
	
	/** 
	 * checks a user's access level against a permission. 
	 * If the user has an access level that contains the permission, it return true
	 * @param $accessLevel a user access level or the accesss level to check against. 
	 * @param $permision a permission to check 
	 * return bool
	 */
	
	
	public static function containsPermission($accessLevel, $permision, $allPermissions = [],$instance) 
	{
		if ( $permision == $accessLevel ) {
			return true;
		}
		
		if ( $permision > $accessLevel ) {
			return false;
		}
		
		if ( empty($allPermissions) ) { //this should only run once. 
			$allPermissions = AccessPermission::find()->all();
			usort($allPermissions, array($instance, "_permissionSort"));
		}
		
		$currentPermission = array_pop($allPermissions);
		
		if ($currentPermission->access_value == $permision) {
			return true;
		}
		
		$instance = $instance;
		
		return $accessLevel - $currentPermission->access_value > 0 ? $instance->containsPermission(  $accessLevel - $currentPermission->access_value, $permision, $allPermissions,$instance ) : $instance->containsPermission(  $accessLevel, $permision, $allPermissions,$instance );
	}
	
	/*
	 * @return integer to indicate if $a ==, < or > $b
	 */
	private  function _permissionSort($a, $b) 
	{
		if ( !( $a instanceof AccessPermission ) || !( $b instanceof AccessPermission ) ) {
			trigger_error('Can only compare agains items of AccessPermission! (' . __METHOD__ . ')', E_USER_NOTICE); 
		}
		
		if ( $a->access_value == $b->access_value ) {
			return 0;
		}
		
		return $a->access_value < $b->access_value ? -1 : 1;
	}

}
