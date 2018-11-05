<?php

namespace frontend\models;

use boffins_vendor\behaviors\DeleteUpdateBehavior;



/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property integer $person_id
 * @property integer $basic_role
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $last_login
 * @property string $last_updated 
 * @property integer $deleted 

  
 * @property Device $device
 */
class UserDbDoNotAttachDateBehavour extends UserDb
{
	
	public function behaviors()
	{
		return ['DeleteUpdate' => DeleteUpdateBehavior::className()];
			
	}
	

	
}
