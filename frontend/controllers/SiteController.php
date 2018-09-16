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

//models
use frontend\models\SignupForm;
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
//Base Class
use boffins_vendor\classes\BoffinsBaseController;


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
                    ],
					
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
		$this->layout = 'new_index_dashboard_layout';
		$folder = new Folder();
		$dashboardFolders = $folder->getDashboardItems(5);
        return $this->render('index',[
			'folders' => $dashboardFolders,
		]);
       
    }

    public function actionLogin() 
	{	
		if ( Yii::$app->request->get('testing') ) {
			Yii::$app->session->destroy();
			Yii::$app->session->close();
			Yii::$app->session->open();
			Yii::$app->user->clearDeviceSessionAndCookieData( ['authenticateNewDevice'], ['deviceString', 'ds'] );
		}
		
		
		$model = new LoginForm();
		$this->layout = 'loginlayout';
		$authenticated = false;
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
				]);			
			}
		}
		
		if ($authenticated) {
			$landingPage = ['site/index']; //isset(Yii::$app->session['comingFrom']) ? Yii::$app->session['comingFrom'] : Url::to(['/site/index']);
			return $this->redirect($landingPage);
		}
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

  public function actionSignup($cid, $email)
    {
		$this->layout = 'loginlayout';
       $user = new SignupForm;
       $customer = \frontend\models\Customer::find()->where([
       	'master_email' => $email,
       	'cid' => $cid,
       	'status' => 0,
		])->one();
		
		if(!empty($customer)){
	        if ($user->load(Yii::$app->request->post())) {
	        	$user->address = $email;
	        	$user->cid = $cid;
				if($user->save()){
					$customer->status = 1;
					$customer->save();
					return $this->redirect(['index']);
				} 
			} else {
	            return $this->render('createUser', [
					'userForm' => $user,
					'action' => ['createUser'],
				]);
			}
		} else {
			throw new ForbiddenHttpException(Yii::t('yii', 'This page does not exist or you do not have access'));
		}
    }

    public function actionCustomersignup()
    {
		$this->layout = 'loginlayout';
       $customer = new CustomerSignupForm;
		
		
        //yii\helpers\VarDumper::dump(Yii::$app->request->post());
        if ($customer->load(Yii::$app->request->post())) {
        	if($customer->signup()){
        		$sendEmail = \Yii::$app->mailer->compose()
        		->setTo($customer->master_email)
				->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . 'robot'])
				->setSubject('Signup Confirmation')
				->setTextBody("Click this link ".\yii\helpers\Html::a('confirm',
				Yii::$app->urlManager->createAbsoluteUrl(
				['site/signup','email'=>$customer->master_email,'cid'=>$customer->cid]
				))
				)->send();
				if($sendEmail){
					Yii::$app->getSession()->setFlash('success','Check Your email!');
				} else{
					Yii::$app->getSession()->setFlash('warning','Something wrong happened, try again!');
				}
			}
		} else {
            return $this->render('createCustomer', [
				'customerForm' => $customer,
				'action' => ['createCustomer'],
			]);
		}
    }

}
