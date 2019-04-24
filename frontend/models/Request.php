<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\GlobalComponent;

/**
 * This is the model class for table "{{%request}}".
 *
 * @property string $id A request id. Unique identifier
 * @property string $session_id Foreign table to session table
 * @property int $user_id A foreign table to the user table
 * @property int $is_ajax Tiny int to indicate if this request was Ajax
 * @property int $is_console Tiny int to indicate if this request was a console request
 * @property string $method Correlates to a constand which indicates what the request method is
 * @property string $url URL requested by the user. Not up to 1000 characters 
 * @property string $user_agent URL requested by the user. Not up to 1000 characters 
 * @property string $start_time The time the request starts (rough estimate)
 * @property string $end_time The time the request ends (rough estimate)
 *
 * @property Activity $activity
 * @property UserDb $user
 * @property Session $session
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%request}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['user_id', 'is_ajax', 'is_console'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['id', 'session_id'], 'string', 'max' => 64],
            [['method'], 'string', 'max' => 20],
            [['url', 'user_agent'], 'string', 'max' => 1000],
            [['id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserDb::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['session_id'], 'exist', 'skipOnEmpty' => true, 'skipOnError' => true, 'targetClass' => Session::className(), 'targetAttribute' => ['session_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'A request id. Unique identifier',
            'session_id' => 'Foreign table to session table',
            'user_id' => 'A foreign table to the user table',
            'is_ajax' => 'Tiny int to indicate if this request was Ajax',
            'is_console' => 'Tiny int to indicate if this request was a console request',
            'method' => 'Correlates to a constand which indicates what the request method is',
            'url' => 'URL requested by the user. Not up to 1000 characters ',
            'user_agent' => 'URL requested by the user. Not up to 1000 characters ',
            'start_time' => 'The time the request starts (rough estimate)',
            'end_time' => 'The time the request ends (rough estimate)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasMany(Activity::className(), ['request_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserDb::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSession()
    {
        return $this->hasOne(Session::className(), ['id' => 'session_id']);
	}
		
	/**
	 * @inheritdoc
	 * 
	 * @details note that at initialisation, only the id can be generated. 
	 * only at the termination of the request can other properties be set as those 
	 * properties, in many cases, will not persist until the end of the request 
	 * for instance, a user identity does not exist before the request to login 
	 * but after the request. In addition, a session id, is equally regenerated at login 
	 * so the value before the request is different after the request (assuming successful login)
	 * as the session may be regenerated once login is successful. 
	 */
	public function init()
	{
		parent::init();
		$this->id = GlobalComponent::generateRandomAlphaNumericString(64);
	}
	
	/**
	 *  @brief a process to execute just before the request is complete. 
	 *  
	 *  @return void
	 *  
	 *  @details This is at the point at which the request can set other properties excluding initial ID. 
	 *  sets user_id, session_id, is_ajax, request_method, request_url
	 */
	public function complete()
	{
		if ( isset(Yii::$app->session) ) { // if this request has a session - otherwise it could be a none web request
			$this->session_id = Yii::$app->session->id;
		}
		
		if ( isset(Yii::$app->user->identity) ) { //console requests won't have user components 
			$this->user_id = Yii::$app->user->identity->id;
		}
		
		if ( isset(Yii::$app->request) ) { 
			$this->is_ajax = Yii::$app->request->isAjax ? 1 : 0;
			$this->is_console = Yii::$app->request->isConsoleRequest ? 1 : 0;
			$this->user_agent = Yii::$app->request->userAgent;
			$this->method = Yii::$app->request->method;
			$this->url = Yii::$app->request->url;
		}		
		$ajax = Yii::$app->request->isAjax ? 1 : 0;
		//Yii::warning("Ajax: {$this->is_ajax}, OR {$ajax}, Method: {$this->method}, URL: {$this->url} ", "Request Model" );
	}
}
