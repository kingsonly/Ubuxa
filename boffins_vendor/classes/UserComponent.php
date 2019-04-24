<?php 
/**
 * @copyright Copyright (c) 2017 Tycol Main (By Epsolun Ltd)
 */

namespace boffins_vendor\classes;

use Yii;
use yii\web\User;


class UserComponent extends User 
{
	/*
	 * Keys of the items that are stored in the identity Cookie that is saved upon login. 
	 */
	public $cookieItemKeys = [ 'id', 'authKey', 'duration'  ];
	/*
	 * Cookie configuration for the device Cookie. 
	 */
	public $deviceCookieConfig = ['name' => 'ds', 'httpOnly' => true]; // httpOnly ensures this cookie cannot be stolen via javascrpt. Set to false if you absolutely need it. 
	/* 
	 * Device through which user is authenticated. When instantiated, it will be of class \frontend\models\Device 
	 */
	private $_device = false;
	/*
	 * An array of custom session variables. To keep a track of what to delete when necessary. 
	 */
	private $_customSessionParams = [];
	
	/*
	 * An array of custom cookies. To keep a track of what to delete when necessary. 
	 */
	private $_customCookies = [];

	
	private function _getDataFromIdentityCookie($data = 'authKey') 
	{
		$value = Yii::$app->getRequest()->getCookies()->getValue($this->identityCookie['name']);
		
		if ( empty($value) ) {
			return null;
		}
		
		$cookieData = json_decode($value, true);
		if ( count($cookieData) != count($this->cookieItemKeys) ) {
			return null;
		}
		Yii::$app->session['cookie'] = $cookieData;
		
		Switch ($data) {
			case 'id':
				return $cookieData[0];
			case 'authKey':
				return $cookieData[1];
			case 'duration':
				return $cookieData[2];
		}
	}
	
	public function getAuthKeyFromCookie() 
	{
		$value = Yii::$app->getRequest()->getCookies()->getValue($this->deviceCookieConfig['name']);
		
		$cookieData = empty($value) ? NULL : json_decode($value, true);
		
		return $cookieData;
	}
	
	public function getIDFromCookie()
	{
		return $this->_getDataFromIdentityCookie('id');
	}
	
	public function getDurationFromCookie()
	{
		return $this->_getDataFromIdentityCookie('duration');
	}
	
	public function addCookie( $cookieName, $cookieValue, $replace = true )
	{
		// get the cookie collection (yii\web\CookieCollection) from the "response" component
		$cookies = Yii::$app->response->cookies; //to read cookies, use request. To send/update cookies, use response 

		// add a new cookie to the response to be sent
		$cookies->add(new \yii\web\Cookie([
			'name' => $cookieName,
			'value' => $cookieValue,
		]));
	}
	
	public function removeCookie( $cookieName )
	{
		// get the cookie collection (yii\web\CookieCollection) from the "response" component
		$cookies = Yii::$app->response->cookies; //to read cookies, use request. To send/update cookies, use response 
		if ( !isset($cookies[$cookieName]) ) {
			return false;
		}			
		// remove a cookie
		$cookies->remove($cookieName);
		// equivalent to the following
		unset($cookies[$cookieName]);
		return true;
	}
	
	public function getCookie( $cookieName ) 
	{
		$cookies = Yii::$app->request->cookies; //to read cookies, use request. To send/update cookies, use response 
		return $cookies->has($cookieName) ? $cookies->get($cookieName) : NULL;
	}
	
	public function getCookies()
	{
		return Yii::$app->request->cookies; //to read cookies, use request. To send/update cookies, use response 
	}
	
	public function hasCookie( $cookieName ) 
	{
		$cookies = Yii::$app->request->cookies; //to read cookies, use request. To send/update cookies, use response 
		return $cookies->has($cookieName);
	}
	
	public function getDevice() 
	{
		if ( !$this->_device ) {
			$this->_device = \frontend\models\Device::getDevice( $this->getAuthKeyFromCookie() );
		}
		return $this->_device;
	}
	
    /**
     * Sends a device cookie.
     * It saves the device authKey, Device::authKey, 
     * @param Device $device
     */
	public function sendDeviceCookies($device)
    {
		if ( ! $device instanceof \frontend\models\Device ) {
			trigger_error("device parameter is not of type Device. " . __METHOD__, E_USER_NOTICE);
			return;
		}
        $cookie = new yii\web\Cookie($this->deviceCookieConfig);
        $cookie->value = json_encode([
            $device->authKey,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $cookie->expire = strtotime($device->valid_to);
        Yii::$app->getResponse()->getCookies()->add($cookie);
    }
	
	public function addSessionState($stateName, $stateValue) 
	{
		$session = Yii::$app->session;
		$session->set($stateName, $stateValue); 
		$this->_customSessionParams[] = $stateName;

	}
	
	protected function deleteCustomSessionVars( $customVars = array() ) 
	{
		if (empty($customVars) ) {
			$customVars = $this->_customSessionParams;
		}
		$session = Yii::$app->session;
		foreach ( $customVars as $var ) {
			$session->remove($var);
		}
	}
	
	protected function deleteCustomCookies( $cookieItems = array() )
	{
		if (empty($cookieItems) ) {
			$cookieItems = $this->_customCookies;
		}
		$cookies = Yii::$app->response->cookies; //use response not request because you are modifying cookies
		foreach ( $cookieItems as $item ) {
			$cookies->remove($item);
		}
	}
	
	public function clearDeviceSessionAndCookieData( $customSessionItems = array(), $customCookieItems = array() )
	{
		$this->deleteCustomCookies($customCookieItems);
		$this->deleteCustomSessionVars($customSessionItems);
	}
	
	/* 
	 * checks a user's access level against a permission. 
	 * If the user has an access level that contains the permission, it return true
	 * @param $accessLevel a user access level or the accesss level to check against. 
	 * @param $permision a permission to check 
	 * return bool
	 */
	public function containsPermission($accessLevel, $permision, $allPermissions = []) 
	{
		if ( $permision == $accessLevel ) {
			return true;
		}
		
		if ( $permision > $accessLevel ) {
			return false;
		}
		
		if ( empty($allPermissions) ) { //this should only run once. 
			$allPermissions = \frontend\models\AccessPermission::find()->all();
			usort($allPermissions, array($this, "_permissionSort"));
		}
		
		$currentPermission = array_pop($allPermissions);
		
		if ($currentPermission->access_value == $permision) {
			return true;
		}
		
		return $accessLevel - $currentPermission->access_value > 0 ? $this->containsPermission(  $accessLevel - $currentPermission->access_value, $permision, $allPermissions ) : $this->containsPermission(  $accessLevel, $permision, $allPermissions );
	}
	
	private function _permissionSort($a, $b) 
	{
		if ( !( $a instanceof \frontend\models\AccessPermission ) || !( $b instanceof \frontend\models\AccessPermission ) ) {
			trigger_error('Can only compare agains items of AccessPermission! (' . __METHOD__ . ')', E_USER_NOTICE); 
		}
		
		if ( $a->access_value == $b->access_value ) {
			return 0;
		}
		
		return $a->access_value < $b->access_value ? -1 : 1;
	}
	
	/*
	 * Ensure that the authentication items are stored for the user. 
	 */
	public function beforeLogin($identity, $cookieBased, $duration) 
	{
		parent::beforeLogin($identity, $cookieBased, $duration);
		$runtimeController = new \boffins_vendor\access\RuntimeController('runtime', Yii::$app); 
		$runtimeController->runAction('init');
		return true;
	}
	
	public function adminTestingMultiple() 
	{ 
		return !empty(Yii::$app->request->get('testingMultiple')) ;
	}

	
}
