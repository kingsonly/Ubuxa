<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use api\models\LoginForm;
use api\models\ChatNotificationEmail;
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
use frontend\models\UserDb;
use frontend\models\TenantEntity;
use frontend\models\TenantCorporation;
use frontend\models\TenantPerson;
use api\models\ApiFolder;
use frontend\models\UserSetting;
use frontend\models\SignupForm;
use frontend\models\Email;
use frontend\models\ChatNotification;
use api\models\InviteUsersForm;
use yii\mongodb\Query;
use yii\helpers\Url;


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
                'exclude' => ['authorize', 'register', 'accesstoken','index','customer-signup','request-password-reset', 'signups', 'validate-code', 'invite-users','chat-email','list-users','chat-list'],
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
                    'chat-list' => ['GET'],
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
        return Yii::$app->apis->sendSuccessResponse([Url::base()]);
        //  return $this->render('index');
    }

	public function actionChatEmail($id)
    {
		$msgArray = [];
		$model = new ChatNotificationEmail();
		$reciever = '';
		foreach(json_decode($id, true) as $key => $value ){
			$userModels = new UserDb();
			$folderModels = new ApiFolder();
			$extractString = explode(')',$value);
			$username = $extractString[0];
			$folderId = $extractString[2];
			$userModel = $userModels->find()->where(['username' => $username])->one();
			$recievers = $userModels->find()->where(['username' => $username])->one();
			$folderModel = $folderModels->find()->where(['id' => $folderId])->asArray()->one();

			$msgArray[$key]['fullname'] = $userModel->fullName;
			$msgArray[$key]['foldertitle'] = $folderModel['title'];
			$msgArray[$key]['msg'] = $extractString[1];
			$reciever = $recievers->email;

		}
		$model->sendEmail($msgArray,$reciever);
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

            return Yii::$app->apis->sendSuccessResponse($data);

        }

    }

	public function actionCustomerSignup()
    {

        $model = new CustomerSignup();
        $model->attributes = $this->request;

        if ($user = $model->signup()) {

            $data=$user;


            return Yii::$app->apis->sendSuccessResponse($data);

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

        return Yii::$app->apis->sendSuccessResponse($data);
    }

    public function actionAccesstoken()
    {

        if (!isset($this->request["authorization_code"])) {
            return Yii::$app->apis->sendFailedResponse("Authorization code missing");
        }

        $authorization_code = $this->request["authorization_code"];

        $auth_code = AuthorizationCodes::isValid($authorization_code);
        if (!$auth_code) {
            return Yii::$app->apis->sendFailedResponse("Invalid Authorization Code");
        }

        $accesstoken = Yii::$app->api->createAccesstoken($authorization_code);
        $userId = $accesstoken->user_id;
        $user = UserDb::findOne($userId);
        $firstname = $user['firstname'];
        $fullname = $user['fullname'];
        $profilePhoto = $user['profile_image'];

        $data = [];
        $data['access_token'] = $accesstoken->token;
        $data['expires_at'] = $accesstoken->expires_at;
        $data['user']['firstname'] = $firstname;
        $data['user']['fullname'] = $fullname;
        $data['user']['profilePhoto'] = !empty($profilePhoto)?'http://ubuxa.net/'.$profilePhoto:'http://ubuxa.net/images/users/default-user.png';
        $data['user']['username'] = $user['username'];
        $data['user']['id'] = $user['id'];
        return Yii::$app->apis->sendSuccessResponse($data);

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

            return Yii::$app->apis->sendSuccessResponse($data);
        } else {
            return Yii::$app->apis->sendFailedResponse($model->errors);
        }
    }

    public function actionLogout()
    {
        $headers = Yii::$app->getRequest()->getHeaders();
        $access_token = $headers->get('x-access-token');

        if(!empty($access_token)){
            if(!$access_token){
                $access_token = Yii::$app->getRequest()->getQueryParam('access-token');
            }

            $model = AccessTokens::findOne(['token' => $access_token]);

            if ($model->delete()) {

                return Yii::$app->apis->sendSuccessResponse(["Logged Out Successfully"]);

            } else {
                return Yii::$app->apis->sendFailedResponse("Invalid Request");
            }
        }else{
            return Yii::$app->apis->sendFailedResponse("Invalid Access Token");
        }
    }

	public function actionValidateCode()
    {
		$model = new ValidateEmail();
		$model->attributes = $this->request;
        if (!empty($model->validateEmail())) {
			$customerId = $model->validateEmail()->customer_id;
			$customer = new Customer();
			$getCustomerEntity = $customer->find()->andWhere(['cid' => $customerId])->one();
            $customerModel = $customer->find()->andWhere(['cid' => $customerId])->asArray()->one();
			$customerModel['role'] = 1;
			$customerModel['account_type'] = $getCustomerEntity->entity->entity_type;
			$customerModel['validation_code'] = $model->validation_code;
			//$checkIfCodeIsValid->delete();
            return Yii::$app->apis->sendSuccessResponse([$customerModel]);

        }else{
			return Yii::$app->apis->sendFailedResponse([$model->errors]);

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
					//unset($data['password_hash']);
					//unset($data['password_reset_token']);
					return Yii::$app->apis->sendSuccessResponse([$user]);

				} else{
					return Yii::$app->apis->sendFailedResponse([$user->errors]);
				}

			} else {
				return Yii::$app->apis->sendFailedResponse(['Customer does not exist']);
			}
		}else {
			return Yii::$app->apis->sendFailedResponse(['User already exist']);
		}
    }

	public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
		$model->attributes = $this->request;
		if ($model->sendEmail()) {
			return Yii::$app->apis->sendSuccessResponse($model);
			//return $this->goHome();
		} else {
			return Yii::$app->apis->sendFailedResponse([$model->errors]);
		}


    }

    public function actionInviteUsers($folderid=0)
    {

        $newTest = $this->request;
        foreach($newTest as $test){
             $model = new InviteUsersForm;
            $model->attributes = $test;
            $folderId = $folderid;
            $emails = $model->email;
            $role = $model->role;
            if(!empty($emails)){
                if($model->sendEmail($emails, $folderid, $role)){
                    return Yii::$app->apis->sendSuccessResponse($model->attributes);
                } else {
                    Yii::$app->api->sendFailedResponse([$model->errors]);
                }
            } else {
                return Yii::$app->apis->sendFailedResponse("Email cannot be empty");
            }
        }

    }

    public function actionListUsers()
    {
        $model = new UserDb();
        $dataProvider =$model->find()->all();
        $userData = [];
        if(!empty($dataProvider)){
            foreach ($dataProvider as $data) {
               array_push($userData, $data->fullName);
            }
            return Yii::$app->apis->sendSuccessResponse($userData);
        }
    }

	public function actionChatList($username)
	{
		$splitUserName = explode('-',$username);
		$data = [];
		$query = new Query();
		// compose the query
		$query->select([])
			->from('rooms')
			->where(['name1' => ['$regex' => $username]])
			->orWhere(['name2' => ['$regex' => $username]]);

		// execute the query
		$rows = $query->all();
		$i=0;
		foreach($rows as $key => $value){

			$name1 = explode('-',$value['name1']);
			$name2 = explode('-',$value['name2']);
			if($splitUserName[0] == $name1[0]){
				$nonrequesterusername  = $name2[0];
			}else{
				$nonrequesterusername  = $name1[0];
			}

			if($splitUserName[1] === $name1[2]){

					$chats = new Query();
					$roomId = (string) $value['_id'] ;
					$chats->from('chats')->where(['room' => ['$eq' => $roomId]])->addOptions(['sort'=>['createdOn' => -1]]);
					$chatRows = $chats->one();
					$model = new UserDb();
					$dataProvider = $model->find()->where(['username' => $nonrequesterusername])->one();
					if(!empty($chatRows['msg']) and !empty($dataProvider->fullName) ){
						$data[$i]['name'] = $dataProvider->fullName;
						$data[$i]['avatar'] = 'http://ubuxa.net/'.$dataProvider->profile_image;
						$data[$i]['unread'] = 0;
						$data[$i]['lastTime'] = (string) $chatRows['createdOn'];
						$data[$i]['lastTime2'] = date('m-d-Y H-i-s', (string) $chatRows['createdOn']);
						$data[$i]['lastMessage'] = $chatRows['msg'];
						$data[$i]['roomid'] = $roomId;
						$data[$i]['username'] = $dataProvider->username;
						$data[$i]['userid'] = $dataProvider->id;
						$data[$i]['roomId'] = (string) $value['_id'];
						$data[$i]['folderId'] = $splitUserName[1];
						$i++;
				}
			}
		}
		 usort($data, function($a, $b) {
			return $a['lastTime'] <= $b['lastTime'];
		 });
		return Yii::$app->apis->sendSuccessResponse($data);
	}

}
