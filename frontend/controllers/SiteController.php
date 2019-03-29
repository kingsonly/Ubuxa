<?php

namespace frontend\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\db\Expression;
use yii\helpers\Json;
use yii\web\Session;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\base\Exception;

//models
use frontend\models\SignupForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\Email;
use frontend\models\Address;
use frontend\models\Telephone;
use frontend\models\Entity;
use frontend\models\EmailEntity;
use frontend\models\AddressEntity;
use frontend\models\TelephoneEntity;
use frontend\models\UserForm;
use frontend\models\LoginForm;
use frontend\models\Folder;
use frontend\models\CustomerSignupForm;
use frontend\models\Customer;
use frontend\models\InviteUsersForm;
use frontend\models\Task;
use frontend\models\Remark;
use frontend\models\TenantEntity;
use frontend\models\TenantCorporation;
use frontend\models\TenantPerson;
use frontend\models\StatusType;
use frontend\models\UserDb;
use frontend\models\Reminder;
use frontend\models\TaskAssignedUser;
use frontend\models\Onboarding;
use frontend\models\Label;
use frontend\models\TaskLabel;
use frontend\models\Plan;
use frontend\models\Role;
use frontend\models\UserSetting;
use linslin\yii2\curl;
use google\apiclient;



//Base Class
use boffins_vendor\classes\BoffinsBaseController;

set_include_path(Yii::$app->BasePath  . '/vendor/google/apiclient/src');

class SiteController extends BoffinsBaseController {
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
			
			
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() 
	{
		//$this->layout = 'new_index_dashboard_layout';
		$folder = new Folder();
		$dashboardFolders = $folder->getDashboardItems(100);
		$task = new Task();
		$remarkModel = new Remark();
		$taskStatus = StatusType::find()->where(['status_group' => 'task'])->all();
		$reminder = new Reminder();
		$label = new label();
        $taskLabel = new TaskLabel();
		$taskAssignedUser = new TaskAssignedUser();
		$cid = Yii::$app->user->identity->cid;
        $users = UserDb::find()->where(['cid' => $cid])->all();
        $allUsers = new UserDb;
        $userId = Yii::$app->user->identity->id;
        $onboardingExists = Onboarding::find()->where(['user_id' => $userId])->exists(); 
        $onboarding = Onboarding::findOne(['user_id' => $userId]);

        if(empty($dashboardFolders)){
        	return $this->render('empty_index',[
        	'taskStatus' => $taskStatus,
			'folders' => $dashboardFolders,
			'task' => $task,
			'remarkModel' => $remarkModel,
			'reminder' => $reminder,
			'taskAssignedUser' => $taskAssignedUser,
			'users' => $users,
			'label' => $label,
            'taskLabel' => $taskLabel,
            'folder' => $folder,
            'allUsers' => $allUsers,
            'userId' => $userId,
            'onboardingExists' => $onboardingExists,
            'onboarding' => $onboarding,
			]);
        } else {
				
	        return $this->render('index',[
	        	'taskStatus' => $taskStatus,
				'folders' => $dashboardFolders,
				'task' => $task,
				'remarkModel' => $remarkModel,
				'reminder' => $reminder,
				'taskAssignedUser' => $taskAssignedUser,
				'users' => $users,
				'label' => $label,
	            'taskLabel' => $taskLabel,
	            'folder' => $folder,
	            'allUsers' => $allUsers,
	            'userId' => $userId,
	            'onboardingExists' => $onboardingExists,
            	'onboarding' => $onboarding,
				]);
   		 }
       
    }

    public function actionLogin() 
	{	
		if (!Yii::$app->user->isGuest) {
			return Yii::$app->getResponse()->redirect(Url::to(['folder/index']));
        }
		
		
		if ( Yii::$app->request->get('testing') ) {
			Yii::$app->session->destroy();
			Yii::$app->session->close();
			Yii::$app->session->open();
			Yii::$app->user->clearDeviceSessionAndCookieData( ['authenticateNewDevice'], ['deviceString', 'ds'] );
		}
		
		
		$model = new LoginForm();
		$this->layout = 'loginlayout';
		$authenticated = false;
		
		//var_dump(Url::base());
		if (strpos(Url::base(true), '.') !== false) {
			
			$seperateUrl = explode(Url::base(true),'.');
			$costomerCompanyName = Customer::find()->where(['master_doman' => $seperateUrl[0]])->one();
			if(count($seperateUrl) > 2){
				if(!empty($costomerCompanyName)){
					if($costomerCompanyName->entityName == 'individual'){
						$accountName = $costomerCompanyName->entity->surname.'s account';
					}else{
						$accountName = $costomerCompanyName->entity->corporation->name.' account';
					}
				}else{
					// redirect to url not on system page 
					return $this->render('nodomainname', [
						'domainName' => $seperateUrl[0],
					]);		
				}
			}
			$accountName = 'your account';
		}else{
			$accountName = 'your account';
		}
		
		
		if ( isset(Yii::$app->session['authenticateNewDevice']) 
			&& Yii::$app->session['authenticateNewDevice'] === true ) {
			$model->scenario = $model::SCENARIO_LOGIN_NEW_DEVICE;
			if ( $model->load(Yii::$app->request->post()) ) { 
				if ( $model->login() ) {
					$authenticated = true;
				} else {
					Yii::$app->session->setFlash('error', 'Invalid login details.');
					return $this->render('authenticate_new_device', [
						'model' => $model,
					]);
				}
			} else {
				return $this->render('authenticate_new_device', [
					'model' => $model,
				]);			
			}
		} elseif ( isset(Yii::$app->session['newDevice']) 
					&& Yii::$app->session['newDevice'] === true ) {
			return $this->render('new_device', [
				'model' => $model,
			]);
		} else {
			$model->scenario = $model::SCENARIO_LOGIN;
			if ( $model->load(Yii::$app->request->post()) ) {
				
				if ( $model->login() ) {
					
					$authenticated = true;
				} elseif ( isset(Yii::$app->session['authenticateNewDevice']) 
							&& Yii::$app->session['authenticateNewDevice'] === true ) {
					return $this->render('new_device', [
						'model' => $model,
					]);
				} else {
					Yii::$app->session->setFlash('error', 'Invalid login details.');
					return $this->render('login', [
						'model' => $model,
					]);
				}		
			} else {
				return $this->render('login', [
					'model' => $model,
					'accountName' => $accountName,
				]);	
				//var_dump($model);
				
			}
		}
		
		if ($authenticated) {
			$this->PostExample(yii::$app->user->identity->username);
			$landingPage = ['folder/index']; //isset(Yii::$app->session['comingFrom']) ? Yii::$app->session['comingFrom'] : Url::to(['/site/index']);
			return $this->redirect($landingPage);
		}
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

  public function actionSignup($email,$cid,$role)
    {
		if (!Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(Url::to(['folder/index']));
        }
		$this->layout = 'loginlayout';
       $user = new SignupForm();
       $customer = Customer::find()->where(['cid' => $cid])->one();
       $userExists = Email::find()->where(['address' => $email])->exists();
       
       if(!$userExists){
			if(!empty($customer)){
		        if ($user->load(Yii::$app->request->post())) {
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
						$newUser = UserDb::findOne([$user->id]);
			            if (Yii::$app->user->login($newUser)){
			                return $this->redirect(['folder/index']);
			            }
					} 
				} else {
		            return $this->render('createUser', [
		            	'customer' => $customer,
						'userForm' => $user,
						'action' => ['createUser'],
					]);
				}
			} else {
				throw new ForbiddenHttpException(Yii::t('yii', 'This page does not exist or you do not have access'));
			}
		}else {
			return $this->goHome();
		}
    }

    public function actionCustomersignup()
    {
		if (!Yii::$app->user->isGuest) {
           return Yii::$app->getResponse()->redirect(Url::to(['folder/index']));
        }
		
		$this->layout = 'loginlayout';
		$customerModel = new Customer();
       	$customer = new CustomerSignupForm;
       	$tenantEntity = new TenantEntity();
       	$tenantCorporation = new TenantCorporation();
       	$tenantPerson = new TenantPerson();
		$settings = new UserSetting();
		
		$settings->logo = Yii::$app->settingscomponent-> boffinsDefaultLogo();
		$settings->theme = Yii::$app->settingscomponent->boffinsDefaultTemplate();
		$settings->language = Yii::$app->settingscomponent->boffinsDefaultLanguage();
		$settings->date_format = Yii::$app->settingscomponent->boffinsDefaultDateFormart();
		
        if ($customer->load(Yii::$app->request->post()) && $tenantEntity->load(Yii::$app->request->post())) {
			
        	$email = $customer->master_email;
        	$date = strtotime("+7 day");
        	$customer->billing_date = date('Y-m-d', $date);
        	
        	
        	if($tenantEntity->save()){
        		if($tenantEntity->entity_type == TenantEntity::TENANTENTITY_PERSON){
        			if($tenantPerson->load(Yii::$app->request->post())){
        				$tenantPerson->entity_id = $tenantEntity->id;
        				$tenantPerson->create_date = new Expression('NOW()');
        				$tenantPerson->save(false);
        			}
        		}elseif ($tenantEntity->entity_type == TenantEntity::TENANTENTITY_CORPORATION) {
        			if($tenantCorporation->load(Yii::$app->request->post())){
        				$tenantCorporation->entity_id = $tenantEntity->id;
        				$tenantCorporation->create_date = new Expression('NOW()');
        				$tenantCorporation->save(false);
        			}
        		}
        		$customer->entity_id = $tenantEntity->id;
	        	if($customer->signup($customerModel)){
	        		$settings->tenantID = (int)$customerModel->cid;
					if($settings->save()){
						$registrationLink = 'http://'.$customer->master_doman.'.ubuxa.net'.\yii\helpers\Url::to(['site/signup','cid' => $customerModel->cid, 'email' => $email, 'role' => 1]);
						/*
						$sendEmail = \Yii::$app->mailer->compose()
						
						->setTo($email)
						->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . 'robot'])
						->setSubject('Signup Confirmation')
						->setTextBody("Hello, click this link to get started.".\yii\helpers\Html::a('Confirm',
						Yii::$app->urlManager->createAbsoluteUrl(
						['site/signup','cid' => $customerModel->cid, 'email' => $email, 'role' => 1]
						))
						)->send();
						*/
						if($customerModel->sendEmail($email,$registrationLink)){
							 Yii::$app->getSession()->setFlash('success','Check Your email!');
						} else{
							Yii::$app->getSession()->setFlash('warning','Something wrong happened, try again!');
						}
					}
	        	}
	        }
		}else {
	            return $this->render('createCustomer', [
					'customerForm' => $customer,
					'tenantEntity' => $tenantEntity,
					'tenantPerson' => $tenantPerson,
					'tenantCorporation' => $tenantCorporation,
					'action' => ['createCustomer'],
				]);
		}
    }


    public function actionInviteusers()
    {	
    	$model = new InviteUsersForm;
    	if ($model->load(Yii::$app->request->post()))
	    	{	
	    		$emails = $model->email;
	    		if(!empty($emails)){
	    				if($model->sendEmail($emails)){
	    					Yii::$app->getSession()->setFlash('success','Check Your email!');
			
							return 1;
	    				} else {
	    					Yii::$app->getSession()->setFlash('warning','Something wrong happened, try again!');
						
							return 0;
	    				}
	    		} else {
	    			echo "Email cannot be empty";
	    		} 
	    }else{
	    		return $this->renderAjax('inviteUsers', [
				'model' => $model,
			]);
	    }
    }

    public function actionRequestPasswordReset()
    {
    	$this->layout = 'loginlayout';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
    	$this->layout = 'loginlayout';
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');
            return $this->goHome();
        }
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionAjaxValidateForm()
	{	
		$this->layout = 'loginlayout';
        $model = new CustomerSignupForm();
		$formErrors = false;
		Yii::trace('Begin Ajax Validation (Customer)');
		if ( Yii::$app->request->isAjax ) {
			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		}
		
		if( $model->load(Yii::$app->request->post()) ) { 
			$formErrors = ActiveForm::validate($model);
			if ( empty($formErrors) && $formErrors !== false  ) {
				Yii::trace('Ajax validation passed (Customer)');
				return true;
			}
		}
		Yii::trace( 'Ajax Validation failed' );
		return $formErrors;
	}

	 public function actionAjaxValidateUserForm()
	{	
		$this->layout = 'loginlayout';
        $model = new SignupForm();
		$formErrors = false;
		Yii::trace('Begin Ajax Validation (User)');
		if ( Yii::$app->request->isAjax ) {
			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		}
		
		if( $model->load(Yii::$app->request->post()) ) { 
			$formErrors = ActiveForm::validate($model);
			if ( empty($formErrors) && $formErrors !== false  ) {
				Yii::trace('Ajax validation passed (User)');
				return true;
			}
		}
		Yii::trace( 'Ajax Validation failed' );
		return $formErrors;
	}

	public function actionBoard()
	{
		return $this->renderAjax('board');	
	}

    public function actionTask()
    {
    	$task = new Task();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();   
            $checkedid =  $data['id'];

            $model = Task::findOne($checkedid);

            if($model->status_id != $task::TASK_COMPLETED){
            	$model->status_id = $task::TASK_COMPLETED;
            	$model->save();
            } else {
            	$model->status_id = $task::TASK_NOT_STARTED;
            	$model->save();
            }
            
        }
    }

    public function actionNewpage()
    {
    	return $this->render('newpage');
    }
	
	public function PostExample($username)
    {
        //Init curl
        $curl = new curl\Curl();

        //post http://example.com/
        $response = $curl->setOption(
                CURLOPT_POSTFIELDS, 
                http_build_query(array(
                    'email' => $username
                )
            ))
            ->post('127.0.0.1:4000/api');
    }
	
	public function actionUpdateSocketUserStack(){
		$session = Yii::$app->session;
		$socketusers = $_REQUEST['activitiesArray'];
		$session->set('socketUsers', $socketusers);
		
	}
	
	public function actionGetChatFolderDetails(){
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$folderId = $_REQUEST['folderId']; // post params from ajax call
		$folderDetails = Folder::findOne($folderId); // get folder details 
		return ['id' => $folderDetails->id,'title' => $folderDetails->title];
		
	}

}
