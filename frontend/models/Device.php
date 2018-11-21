<?php

namespace frontend\models;

use Yii;
use UserAgentParser\Provider;
use boffins_vendor\classes\BoffinsArRootModel;
use boffins_vendor\classes\models\{StandardTenantQuery, TenantSpecific, TrackDeleteUpdateInterface};

/**
 * This is the model class for table "{{%device}}".
 *
 * @property integer $id
 * @property string $authKey
 * @property integer $status_id
 * @property string $device_serial (500)
 * @property date $valid_to	//states how long this device may be used 
 *
 * @property StatusType $status
 */
class Device extends BoffinsArRootModel implements TenantSpecific
{
	/* 
	 * A serialised string indicating browser and operating system (os)
	 */
	private $_deviceString = '';
	
	/* 
	 * A boolan to indicate if this device has just been approved so can be used to login
	 */
	private $_justApproved = false;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%device}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_id'], 'integer'],
            [['browser', 'os', 'authKey'], 'string', 'max' => 255],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusType::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' =>  Yii::t('Device', 'ID'),
            'authKey' =>  Yii::t('Device', 'Auth Key'),
            'status_id' =>  Yii::t('Device', 'Status'),
			'last_used' =>  Yii::t('Device', 'Last Used'),
			'valid_to' =>  Yii::t('Device', 'Expires')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(StatusType::className(), ['id' => 'status_id']);
    }
	
	public function init() 
	{
		parent::init();
		if ($this->isNewRecord) {
			$providerChain = new Provider\Chain([
							new Provider\PiwikDeviceDetector(),
							//new Provider\WhichBrowser(),
						]);
						
			$userAgent = Yii::$app->getRequest()->getUserAgent();
			
			/* @var $parsedUAObj \UserAgentParser\Model\UserAgent */
			$parsedUAObj = $providerChain->parse($userAgent);
			$this->device_serial = serialize($parsedUAObj->toArray());
			$this->authKey = self::generateAuthKey($parsedUAObj->getBrowser(), $parsedUAObj->getOperatingSystem());
			$this->_deviceString = serialize([$parsedUAObj->getBrowser()->getName(), $parsedUAObj->getOperatingSystem()->getName()]);
		}
		
		return true;
	}
	
	public static function getDevice($authKey = '') {
		$device = NULL;
		if (!empty($authKey) ) {
			$device = self::findOne(['authKey' => $authKey]);
		}
		
		if ( empty($device) ) {
			$device = new Device;
		} 
		
		return $device;
	}
	
	protected static function generateAuthKey($browser, $os)
    {
        return Yii::$app->security->generateRandomString(70);
    }
	
	
	public function validateAuthKey($authKey)
	{
		return Yii::$app->security->compareString($this->authKey, $authKey);
	}
	
	public function getDeviceString()
	{
		return $this->_deviceString;
	}
	
	public function similarDeviceString($deviceString)
	{
		return unserialize($this->deviceString) == unserialize($deviceString);
	}
	
	public function approveDevice($deviceAccessToken, $user, $valid_to = '2037-06-30' ) {
		if ( $deviceAccessToken instanceof DeviceAccessToken !== true ) {
			trigger_error( __METHOD__ . " requires a valid DeviceAccessToken instance", E_USER_NOTICE );
			return false;
		}
		
		if ( !$this->isNewRecord ) {
			trigger_error( __METHOD__ . " you are using a device that is already approved", E_USER_NOTICE );
			return false;
		}
		$saved = false;
		if ( $this->validDeviceUser($deviceAccessToken, $user) ) {
			$this->valid_to = $valid_to;
			$saved = $this->save(false); 	//after save, delete device access token, 
											//add user device, remove device string from cookie, remove authenticateNewDevice from session 
			if ($saved) {
				$userDevice = new UserDevice;
				$userDevice->user_id = $deviceAccessToken->user_id;
				$userDevice->device_id = $this->id;
				$this->_justApproved = $saved && $userDevice->save(false) ? true : false;
			}
		}
		
		if ($this->_justApproved) {
			Yii::$app->user->clearDeviceSessionAndCookieData( ['authenticateNewDevice'], ['deviceString'] );
			Yii::$app->user->sendDeviceCookies($this);
			$deviceAccessToken->delete();
		}

		return $this->_justApproved; 
	}
	
	public function getJustApproved()
	{
		return $this->_justApproved;
	}
	
	protected function validDeviceUser($deviceAccessToken, $user) 
	{
		if ( empty($user) ) {
			return false;
		}
		
		
		if ( ! $deviceAccessToken->user_id == $user->getId() ) {
			return $user->basic_role === UserDb::ADMIN_USER;
		}
		
		return true;
		
	}
	
}
