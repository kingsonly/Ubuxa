<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use api\models\LoginForm;
use common\models\AuthorizationCodes;
use common\models\AccessTokens;

//use api\models\SignupForm;
use api\models\ValidateEmail;
use api\models\PasswordResetRequestForm;
use api\behaviours\Verbcheck;
use api\behaviours\Apiauth;
use frontend\models\Customer;
use frontend\models\CustomerSignupForm;
use api\models\CustomerSignup;
use frontend\models\TenantEntity;
use frontend\models\TenantCorporation;
use frontend\models\TenantPerson;
use frontend\models\UserSetting;
use frontend\models\SignupForm;
use frontend\models\Email;

/**
 * Site controller
 */
class SiteController extends RestController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => ['authorize', 'register', 'accesstoken','index','customer-signup','request-password-reset'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'me'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['authorize', 'register', 'accesstoken'],
                        'allow' => true,
                        'roles' => ['*'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'logout' => ['GET'],
                    'authorize' => ['POST'],
                    'register' => ['POST'],
                    'accesstoken' => ['POST'],
                    'me' => ['GET'],
                ],
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->api->sendSuccessResponse(['Yii2 RESTful API with OAuth2']);
        //  return $this->render('index');
    }

    public function actionRegister()
    {

        $model = new SignupForm();
        $model->attributes = $this->request;

        if ($user = $model->signup()) {

            $data=$user->attributes;
            unset($data['auth_key']);
            unset($data['password_hash']);
            unset($data['password_reset_token']);

            Yii::$app->api->sendSuccessResponse($data);

        }

    }
	
	public function actionCustomerSignup()
    {

        $model = new CustomerSignup();
        $model->attributes = $this->request;

        if ($user = $model->signup()) {

            $data=$user;
           

            Yii::$app->api->sendSuccessResponse($data);

        }

    }


    public function actionMe()
    {
        $data = Yii::$app->user->identity;
        $data = $data->attributes;
		$data['id2'] = Yii::$app->user->identity->username;
        unset($data['auth_key']);
        unset($data['password_hash']);
        unset($data['password_reset_token']);

        Yii::$app->api->sendSuccessResponse($data);
    }

    public function actionAccesstoken()
    {

        if (!isset($this->request["authorization_code"])) {
            Yii::$app->api->sendFailedResponse("Authorization code missing");
        }

        $authorization_code = $this->request["authorization_code"];

        $auth_code = AuthorizationCodes::isValid($authorization_code);
        if (!$auth_code) {
            Yii::$app->api->sendFailedResponse("Invalid Authorization Code");
        }

        $accesstoken = Yii::$app->api->createAccesstoken($authorization_code);

        $data = [];
        $data['access_token'] = $accesstoken->token;
        $data['expires_at'] = $accesstoken->expires_at;
        Yii::$app->api->sendSuccessResponse($data);

    }

    public function actionAuthorize()
    {
        $model = new LoginForm();

        $model->attributes = $this->request;


        if ($model->validate() && $model->login()) {

            $auth_code = Yii::$app->api->createAuthorizationCode(Yii::$app->user->identity['id']);

            $data = [];
            $data['authorization_code'] = $auth_code->code;
            $data['expires_at'] = $auth_code->expires_at;

            Yii::$app->api->sendSuccessResponse($data);
        } else {
            Yii::$app->api->sendFailedResponse($model->errors);
        }
    }

    public function actionLogout()
    {
        $headers = Yii::$app->getRequest()->getHeaders();
        $access_token = $headers->get('x-access-token');

        if(!$access_token){
            $access_token = Yii::$app->getRequest()->getQueryParam('access-token');
        }

        $model = AccessTokens::findOne(['token' => $access_token]);

        if ($model->delete()) {

            Yii::$app->api->sendSuccessResponse(["Logged Out Successfully"]);

        } else {
            Yii::$app->api->sendFailedResponse("Invalid Request");
        }


    }
	
	public function actionValidateCode()
    {
		$model = new ValidateEmail();
		$model->attributes = $this->request;
        if (!empty($model->validateEmail())) {
			$customerId = $model->validateEmail()->customer_id;
			$customer = new Customer();
            $customerModel = $customer->find()->andWhere(['cid' => $customerId])->asArray()->one();
			$customerModel['role'] = 1;
			$customerModel['validation_code'] = $model->validation_code;
			//$checkIfCodeIsValid->delete();
            Yii::$app->api->sendSuccessResponse([$customerModel]);

        }else{
			Yii::$app->api->sendFailedResponse([$model->errors]);

		}

    }
	
	public function actionSignups($email,$cid,$role,$validation_code,$folderid = 0)
	{
       	$user = new SignupForm();
       	$customer = Customer::find()->where(['cid' => $cid])->one();
       	$userExists = Email::find()->where(['address' => $email])->exists();
       	$user->attributes = $this->request;
		
       	if(!$userExists){
			
			if(!empty($customer)){
				
				$user->address = $email;
				$user->cid = $cid;
				$user->basic_role = $role;
				if($customer->entityName == TenantEntity::TENANTENTITY_PERSON && $customer->has_admin == Customer::NO_ADMIN){
					
					$user->first_name = $customer->entity->firstname;
					$user->surname = $customer->entity->surname;
				}
				//$user->_userAR->tenantID = $cid;
				if($user->save()){
					
					if($customer->has_admin == Customer::NO_ADMIN){
						$customer->has_admin = Customer::HAS_ADMIN;
						$customer->save();	
					}
					Yii::$app->api->sendSuccessResponse([$user]);
					
				} else{
					Yii::$app->api->sendFailedResponse([$user->errors]);
				}
				
			} else {
				Yii::$app->api->sendFailedResponse(['Customer does not exist']);
			}
		}else {
			Yii::$app->api->sendFailedResponse(['User already exist']);
		}
    }
	
	public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
		$model->attributes = $this->request;
		if ($model->sendEmail()) {
			Yii::$app->api->sendSuccessResponse($model);
			//return $this->goHome();
		} else {
			Yii::$app->api->sendFailedResponse([$model->errors]);
		}


    }
	
}
	
