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
use frontend\models\LoginForm;

//models

use frontend\models\UserForm;
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
		$this->layout = 'indexdashboard';

        return $this->render('index',[]);
       
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

  
	
	  
}
