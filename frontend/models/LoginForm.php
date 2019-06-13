<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
	public $device_token;
    public $domain;
	
	const SCENARIO_LOGIN = 'login';
	
	const SCENARIO_LOGIN_NEW_DEVICE = 'loginNewDevice';

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'device_token'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            ['domain', 'safe'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
			[['device_token'], 'string', 'max' => 8],
			['device_token', 'validateDeviceToken'],
        ];
    }
	
	/***
	 * Sets scenarios for the model. Two are set SCENARIO_LOGIN which is for standard login.
	 * SCENARIO_LOGIN_NEW_DEVICE which is for login using new devices. 
	 */
	public function scenarios()
    {
        return [
            self::SCENARIO_LOGIN => ['username', 'password', 'rememberMe', 'domain'],
			self::SCENARIO_LOGIN_NEW_DEVICE => ['username', 'device_token', 'password'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
				switch ($this->scenario) {
					case self::SCENARIO_LOGIN:
						$this->addError($attribute, 'Incorrect username or password.');
					case self::SCENARIO_LOGIN_NEW_DEVICE:
						$this->addError($attribute, 'Incorrect username, password or token.');
					default: 
						$this->addError($attribute, 'Incorrect username or password.');
				}
                
            }
        }
    }
	
    /**
     * Validates the device token.
     * This method serves as the inline validation for device_token.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
	public function validateDeviceToken($attribute, $params)
	{
		if ( !$this->hasErrors() ) {
			$user = $this->getUser();
			
			if (!$user || !$user->validateDeviceToken($this->device_token)) {
                $this->addError($attribute, 'Incorrect username, password or token.');
			}
		}
	}

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
		if ( ! Yii::$app->session->isActive ) {
			Yii::$app->session->open();
		}
		
        if ( $this->validate() && $this->getUser()->grantAccess() ) {
            return $this->getUser()->login($this->rememberMe); 
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = UserDb::findByUsername($this->username);
        }
        return $this->_user;
    }
}
