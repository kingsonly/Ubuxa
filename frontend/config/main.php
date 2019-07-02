<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
					'queue', 
					'log',
					'activityManager'
					],
    'controllerNamespace' => 'frontend\controllers',
	'on beforeRequest' => ['boffins_vendor\access\ApplicationEventsHandler', 'handleBeforeRequest'],
	'on afterRequest' => ['boffins_vendor\access\ApplicationEventsHandler', 'handleAfterRequest'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
		'assetManager' => [
			'bundles' => [
				'yii\web\JqueryAsset' => [
					'jsOptions' => [ 'position' => \yii\web\View::POS_HEAD ],
				],
			],
		],
	
        'user' => [
			'class' => 'boffins_vendor\classes\UserComponent',
            'identityClass' => 'frontend\models\UserDb',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
			'enableSession' => true,
			//'authTimeout' => 21600, //6 hours 
			'absoluteAuthTimeout' => 172800, //72 hours 
			'on ' . \yii\web\User::EVENT_BEFORE_LOGIN => ['frontend\models\UserDb', 'handleBeforeLogin'],
			'on ' . \yii\web\User::EVENT_AFTER_LOGIN => ['frontend\models\UserDb', 'handleAfterLogin'],
			'on ' . \yii\web\User::EVENT_BEFORE_LOGOUT => ['frontend\models\UserDb', 'handleBeforeLogout'],
			'on ' . \yii\web\User::EVENT_AFTER_LOGOUT => ['frontend\models\UserDb', 'handleAfterLogout'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
			'class' => 'yii\web\DbSession',
            'name' => 'advanced-frontend',
			
		],
		'cache'         => [
			'class' => 'yii\redis\Cache',
		 ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 5 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		'authManager' => [
			'class' => 'yii\rbac\PhpManager',
        ],     
		'settingscomponent' => [
        	'class' => 'frontend\settings\components\SettingsComponent',
    	],
		
		
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],

	'modules' => [
	        'debug' => [
            'class' => \yii\debug\Module::class,
            'panels' => [
                'queue' => \yii\queue\debug\Panel::class,
            ],
        ],
    'settings' => [
        'class' => 'frontend\settings\Module',
		],
		'wiki'=>[
		'class'=>'asinfotrack\yii2\wiki\Module',
		'processContentCallback'=>function($content) {
			//example if you want to use markdown in your wiki
			return Parsedown::instance()->parse($content);
		}
	],
	],

	'defaultRoute' => 'folder/index2', /*deliberately set to index2 which is an empty view as index causes multiple actions 
	to be run when there are missing asset bundles (redirects?). This happens even when you run other actions as somehow 
	the default route is also run???? */

    'params' => $params,
	'as beforeRequest' => [
		'class' => 'yii\filters\AccessControl',
		'rules' => [
			[
				'allow' => true,
				'actions' => ['login','customersignup','signup', 'ajax-validate-form', 'ajax-validate-user-form', 'request-password-reset','ajax-validate-request-password-form','reset-password', 'signin','find-workspace', 'resend-invite'],
				'roles' => ['?'],
			],
			[
				'allow' => true,
				'controllers' =>['apis'],
				//'actions' => ['login'],
				'roles' => ['?'],
			],
			[
				'allow' => true,
				//'actions' => ['logout'],
				'roles' => ['@'],
			],
			/*[
				'allow' => true,
				'roles' => ['?'],
			],*/
		],
		'denyCallback' => function () {
			$comingFrom = ['folder/index']; //you need to determine where you're coming from here. 
			$comingFrom = $comingFrom[0] == 'site/login' || empty($comingFrom[0]) ? [Yii::$app->defaultRoute] : $comingFrom;
			Yii::$app->request->isPjax || Yii::$app->request->isAjax ? Yii::$app->session->set( 'comingFrom', [Yii::$app->defaultRoute] ) : Yii::$app->session->set( 'comingFrom', $comingFrom );
			return Yii::$app->response->redirect(['site/login', 'test' => 2]);
		},
	],

];




