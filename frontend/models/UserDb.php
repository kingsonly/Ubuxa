<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use boffins_vendor\classes\StandardQuery;
use boffins_vendor\behaviors\DeleteUpdateBehavior;
use boffins_vendor\behaviors\DateBehavior;
use yii\web\User;
use boffins_vendor\classes\BoffinsArRootModel;
use boffins_vendor\classes\UserComponent;
use boffins_vendor\classes\models\{StandardTenantQuery, TenantSpecific, TrackDeleteUpdateInterface, KnownClass};
use common\models\UserDevicePushToken as ParentUserDevicePushToken;

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
class UserDb extends BoffinsArRootModel implements TenantSpecific, TrackDeleteUpdateInterface, IdentityInterface, KnownClass
{
	
	/* 
	 * constant value to represent an admin user. 
	 * This user should have full access to everything. 
	 */
	const USER_ADMIN = 'admin';
	/* 
	 * constant value to represent a manager user. 
	 * This user has almost full control but cannot modify users or grant access 
	 */
	const USER_MANAGER = 'manager';
	/* 
	 * constant value to represent an administrator user. 
	 * This user cannot delete/restore or modify users or grant access 
	 */
	const USER_ADMNINISTRATOR = 'administrator';
	/* 
	 * constant value to represent a field officer user.
	 * This user can only update existing components and with limited create access 
	 */
	const USER_FIELD_OFFICER = 'field_officer';
	/* 
	 * constant value to represent a data entry user.
	 * This user can create and update items of some routes, but not all. 
	 */
	const USER_DATA_ENTRY = 'data_entry';
	
	/*
	 * internal variable to determine if the user password was correct. 
	 */
	private $_passwordValid = false;

	//public $profile_image;

	public $controlerLocation = 'frontend';
	
    /***
     * @inheritdoc
     */
	public static function tableName()
    {
        return '{{%user}}';
    } 
	
    /**
     * @inheritdoc
     */
	
    public function rules()
    {
        return [
            [['username','password', 'cid'], 'required'],
            [['password'], 'string', 'min' => 6],
            //[['password_repeat'], 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ],
            [['basic_role','image'], 'safe'],

            //[['username', 'password'], 'string', 'max' => 255],
            //['username', 'validateUsername'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'fullname' => 'Full Name',
            'basic_role' => 'Standard Role',
            'password' => 'Password',
            'dob' => 'Date of Birth',
            //'password_repeat' => 'Repeat Password',
            'salt' => 'Salt',
            'cid' => 'Cid',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
	{
		return self::findOne($id); //find rewritten. And findone, I believe, use find() and one()
	}

    /*
     * @inheritdoc
     */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		throw new NotSupportedException('Access Tokens are not supported: ' . __METHOD__ );	//I don't implement this method as it is not secure 
	}

    /**
     * @inheritdoc
     */
	public function getId()
	{
		return $this->id;
	}
	
	/***
	 * Obtain the authKey from the device 
	 */
    public function getAuthKey()
	{
		return $this->getDevice()->authKey; //get from Device
	}
 
	/***
	 *
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getDevice()->validateAuthKey($authKey); 
	}

    /***
     * @inheritdoc
     */
	public static function findByUsername($username)
	{
		return self::findOne(['username' => $username]);
	}

    /**
     * @inheritdoc
     */
	public static function findById($id)
	{
		return self::findOne(['id' => $id]);
	}
		
	/***
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }

	/***
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'basic_role']);
    }

    public function getRoleName()
    {
        return $this->role->name;
    }
	/***
	 *
	 */
	public function getFullName() 
	{
		return $this->person->personstring;
	}

	public function getFirstName() 
	{
		return $this->person->first_name;
	}

	public function getSurname() 
	{
		return $this->person->surname;
	}

	public function getDob() 
	{
		return $this->person->dob;
	}

	/***
     * @inheritdoc
     */
	public function getUsername() 
	{
		return $this->username;
	}
	
	/***
     * Check correct password
     * @param string $pw password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($pw)
    {
		$this->_passwordValid = Yii::$app->security->validatePassword($pw, $this->password);
		return $this->_passwordValid;
    }
	
    /**
     * Generate a password hash from password and sets it to the model
     * @param string $password
     */
    public function setPassword($pw) //not run as password is a table column so it is set directly not through get/setters. Use before validate
    {
        $this->password = $pw;//Yii::$app->security->generatePasswordHash($pw); // i dont think the setPassword method should encript, as to the fact that a seperate method instantly encripts the password; 
    }
	
	/*
     * Obtain authKey from the device.  - better to use getAuthKey
     */
    public function generateAuthKey()
    {
        return $this->getDevice()->authKey();
    }
	
	/*
	 * Before saving, set password to a hash and salt to a random string. 
	 */
	public function beforeSave($insert)  
	{
		//if($this->isNewRecord or !empty($this->dirtyAttributes['password'])){
			if ($this->isNewRecord) {
				$this->salt = Yii::$app->security->generateRandomString();
				$this->password = Yii::$app->security->generatePasswordHash($this->password);
			} elseif ( !empty($this->dirtyAttributes['password']) ) {
				$this->password = Yii::$app->security->generatePasswordHash($this->password);
			}

		//}
		
		return true;
	}
	
	/**
	 * Get device from user component.
	 */
	public function getDevice() 
	{
		return Yii::$app->user->device;
	}
	
	/*
	 * @inheritdoc
	 */
	public function behaviors()
	{
		
			return [
			'DeleteUpdate' => DeleteUpdateBehavior::className(),
			"dateValues" => [
				"class" => DateBehavior::className(),
				
				"AREvents" => [
						ActiveRecord::EVENT_BEFORE_VALIDATE => [ 'rules' => [
																			DateBehavior::DATE_CLASS_STAMP => [
																					'attributes' => ['last_updated'],
																					],
																			] 
															],
						ActiveRecord::EVENT_AFTER_FIND => [ 'rules' => [
																		DateBehavior::DATE_CLASS_STANDARD => [
																				'attributes' => ['last_updated'],
																				],
																		] 
															],
						UserComponent::EVENT_AFTER_LOGIN => [ 'rules' => [
																DateBehavior::DATE_CLASS_STAMP => [
																		'attributes' => ['last_login'],
																		],
																] 
													],
				],
			],
		];
			
			
    	
		
	}
	
	public function grantAccess()
	{	
		//ensure that at this point, the user identity is confirmed, and valid before authenticating device. 
		if ( $this->authenticateUser() ) {
			return true;//$this->authenticateDevice();
		}
	}
	
	/* 
	 * returns true if user basic_role is admin. 
	 */
	public function isAdmin() 
	{
		return $this->role->name == self::USER_ADMIN;
	}
	
	protected function authenticateUser()
	{
		if ($this->_passwordValid ) {
			Yii::$app->user->setIdentity($this);		//ensure that the application is aware of the user context we are operating in. 
			return true;
		}
		return false;
	}
	
	protected function authenticateDevice()
	{
		$device = $this->getDevice();
		if ( $device->isNewRecord ) {
			if ( Yii::$app->user->hasCookie('deviceString') 
				&& $device->similarDeviceString( Yii::$app->user->getCookie('deviceString') ) 
			) {
				//this device string has been detected before - probably the same, new device. 
				//therefore login should be through token but first check is there is still a valid token because the 
				//token could have expired before approval.
				$validToken = false;
				$deviceAccessTokens = DeviceAccessToken::findAll( ['device_string' => $device->deviceString] );
				if ( !empty($deviceAccessTokens) ) {
					foreach ($deviceAccessTokens as $token ) {
						if ( strtotime($token->valid_to)  < time() ){
							$token->delete();
						} else {
							$validToken = true;
						}
					}
				}
				
				if ( !$validToken ) {
					$deviceAccess = $this->generateNewDeviceAcessToken($device->deviceString);
					$this->emailTokenToAdmins($deviceAccess->token);
				}
				
			} else {
				//generate a OTP (token) through which the user can login 
				$deviceAccess = $this->generateNewDeviceAcessToken($device->deviceString);
				//New Devices have to to be permitted by admin. Send email to admins
				$this->emailTokenToAdmins($deviceAccess->token);
			}
			return false;
			//if the device is being used by an admin, give temporary access 
		} else {
			//check if this user has access on this device. 
			$userDevice = UserDevice::findOne(['user_id' => $this->id, 'device_id' => $this->getDevice()->id]);
			if ( empty($userDevice) ) {
				//if this user is not linked to this device but the user is an admin, grant access. Otherwise, no.
				return $this->isAdmin() || Yii::$app->user->adminTestingMultiple(); ;
			} else {
				return true;
			} 
		}
	}
		
	public static function getAdminEmails()
	{
		$adminID = Role::findOne(['name' => self::USER_ADMIN]);
		$adminUsers = self::findAll(['basic_role' => $adminID->id]);
		$emailAddreses = [];
		foreach ( $adminUsers as $admin ) {
			$emailAddreses[$admin->username] = $admin->email;
		}
		return $emailAddreses;
	}
	
	public function getEmail()
	{
		return $this->person->userEmail;
	}
	
	public function getPushToken()
	{
		return  $this->hasMany(ParentUserDevicePushToken::className(), ['user_id' => 'id']);
	}
	
	public function getTelephone()
	{
		return $this->person->userTelephone;
	}
	
	public function generateNewDeviceAcessToken($deviceString)
	{
		$deviceAccess = new DeviceAccessToken;
		//get Token for login 
		$deviceAccess->token = strtoupper($this->generateRandomAlphaNumericString(8) );
		$validity =  Yii::$app->user->absoluteAuthTimeout; 
		$deviceAccess->valid_to = (new \DateTime())->modify('+1 day')->format('Y-m-d H:i:s');
		$deviceAccess->user_id = $this->id;
		$deviceAccess->device_string = $deviceString;
		Yii::$app->user->addCookie('deviceString', $deviceString);
		Yii::$app->user->addSessionState('authenticateNewDevice', true); 
		return $deviceAccess->save(false) ? $deviceAccess : NULL;
	}
	
	public static function generateRandomAlphaNumericString($length = 32) 
	{
		$approvedCharacters = "23456789abcdefghijklmnopqrstuvwxyz"; //1 and 0 are ommitted so as not to be confused with O OR I
		$result = '';
		$max = strlen($approvedCharacters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$result .= $approvedCharacters[mt_rand(0, $max)];
		}
		return $result;
	}
	
	public function validateDeviceToken($device_token)
	{
		$deviceAccessToken = DeviceAccessToken::findOne(['token' => $device_token]); 
		if ( empty($deviceAccessToken) ) {
			return false;
		}
		$device = $this->getDevice();
		
		if ( !$device->similarDeviceString($deviceAccessToken->device_string) ) {
			return false;
		}
		
		if ( strtotime($deviceAccessToken->valid_to) < time() ) {
			return false;
		}
		
		return $device->approveDevice($deviceAccessToken, $this);
	}

	public function upload()
    {
        if ($this->validate()) {
			$holdPath = '';
			$file = $this->profile_image;
			$ext = $file->extension;
			$newName = \Yii::$app->security->generateRandomString().".{$ext}";
			$basePath = explode('/',\Yii::$app->basePath);
			$this->controlerLocation === 'API'?\Yii::$app->params['uploadPath'] = '../../frontend/web/images/users/':\Yii::$app->params['uploadPath'] = \Yii::$app->basePath.'/web/images/users/';
			//\Yii::$app->params['uploadPath'] = \Yii::$app->basePath.'/web/uploads/';
			\Yii::$app->params['uploadPath'] = '../../frontend/web/images/users/';
			$path = \Yii::$app->params['uploadPath'] . $newName;
			$dbpath = 'images/users/' . $newName;
			
			$holdPath= $dbpath;
			
			if($file->saveAs($path)){
				
				$this->profile_image = $dbpath;
				
			}
			
            return true;
        } else {
            return false;
        }
    }
	

	/*
	protected function emailTokenToAdmins( $token ) 
	{
		$adminEmails = self::getAdminEmails();
		$str = '';
		foreach ( $adminEmails as $index => $email ) {
			$str .= "User {$email}: , ";
			break;
		}
		Yii::info("Preparing Admin Emails: {$str}" );
		//send email to admin to permit device
		$messages = [];
		foreach ( $adminEmails as $key => $email ) {
			$messages[] = Yii::$app->mailer->compose('view-email-token', [
												'token' => $token,
												'user' => $this
												])
												->setFrom('admin@tycol.net')
												->setTo($email) //this limits it to only the first email in the list per admin that is used
												->setSubject("New Access Token for {$this->fullName} - ({$this->username}) ");
		}
		Yii::$app->mailer->sendMultiple($messages);
		


	}*/
	
	protected function emailTokenToAdmins( $token ) 
	{
		$messages = Yii::$app->mailer->compose('view-email-token', [
												'token' => $token,
												'user' => $this
												])
												->setFrom('admin@tycol.net')
												->setTo($this->email) //this limits it to only the first email in the list per admin that is used
												->setSubject("New Access Token for {$this->fullName} - ({$this->username}) ");
		
		Yii::$app->mailer->send($messages);
		
	}
	
	/**
	 *  @brief logs the user in 
	 *  by invoking the yii\web\user::login($identity, $duration) function. 
	 *  $duration is calculated in seconds. 
	 *  @param [bool] $rememberMe Supplied by the user at the point of login - remember my login 
	 *  @return void.
	 */
	public function login($rememberMe = false)
	{
		return Yii::$app->user->login($this, $rememberMe ? 0 : 3600);  //duration in seconds. unlimited if remember, 1 hour if not. 
	}
	
	/***
	 * Get the type of a given attribute 
	 */
	public function getAttributeType($attribute)
	{
		return $this->hasAttribute($attribute) ? self::getTableSchema()->columns[$attribute]->type : trigger_error('This attribute ({$attribute}) does not exist: ' . $attribute . ' ' . __METHOD__);
	}
	
	public static function getRoleTypes() 
	{
		return [ self::USER_ADMIN, self::USER_ADMNINISTRATOR, self::USER_DATA_ENTRY, self::USER_FIELD_OFFICER, self::USER_MANAGER ];
	}
	
	public static function handleBeforeLogin()
	{
		'do nothing';
	}
	public static function handleAfterLogin()
	{
		$user = Yii::$app->user->identity;
		$user->last_login = date('Y-m-d H:i:s');
		Yii::trace('User ' . $user->username .  ' logged in at ' . date('d/m/Y H:i:s') );
		$user->save(false);
		$auth = Yii::$app->authManager;
		$role = $auth->getRole( $user->role->name );
		if ( !empty($role) ) {
			$auth->revokeAll($user->id);
			$auth->assign($role, $user->id);
			Yii::trace('User ' . $user->username .  ' logged in with role: ' . $role->name );
		} else {
			Yii::trace('User ' . $user->username .  ' can not be assigned a role: ' . $user->role->name );
		}
	}

	public  static function handleBeforeLogout()
	{
		//throw new yii\base\Exception("What's going on?");
		'do nothing';
	}
	
	public static function handleAfterLogout()
	{
		'do nothing';
	}
	
	public static function isUser($value, $columnName = 'id')
	{
		$u = new UserDb;
		if ( !$u->hasAttribute($columnName) ) {
			trigger_error('This column does not exist');
			return false;
		}
		
		$user = $u->findOne([ $columnName => $value ]);
		return !empty($user);
	}

	public static function sendDomainName($domain,$usersEmail)
	{
		return Yii::$app->mailer->compose(['html' => 'domain'], [
	            'domain' => $domain
	        ])
	            ->setTo($usersEmail)
	            ->setFrom([\Yii::$app->params['supportEmail'] => 'Ubuxa'])
	            ->setSubject('Ubuxa Workspace')
	            ->send();
	}

	public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
	
	public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            //'status' => self::STATUS_ACTIVE,
        ]);
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
	
	public function getNameString() : string
	{
		return $this->person->nameString;
	}
	
	public function getDropDownListData()
    {
		
        return ArrayHelper::map($this->find()->all(),'id','nameString');
    }
	
	public function getMasterDomain(){
		$masterDomain = Customer::find()->andWhere(['cid' => yii::$app->user->identity->cid])->one();
		return !empty($masterDomain)? $masterDomain->master_doman :'';
	}

    public function getUserReminders()
    {
        return $this->hasMany(CalendarReminder::className(), ['user_id' => 'id']);
    }

	public function getReminders()
    {
        return $this->hasMany(Reminder::className(), ['id' => 'reminder_id'])->via('userReminders');
    }
}