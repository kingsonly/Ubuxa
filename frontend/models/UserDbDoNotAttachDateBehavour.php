<?php

namespace frontend\models; //this model should be in a different namespace - possibly a lot closer to where it is required. 

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
	
	public function behaviors() //I am incredibly surprised that this does not cause errors. It's parent's parent makes this a final class!
								//AAO 06/11/18
	{
		return ['DeleteUpdate' => DeleteUpdateBehavior::className()];
			
	}
	

	
}
