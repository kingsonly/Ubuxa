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
    'bootstrap' => ['log'],
	'language'=>'en-US',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
			'class' => 'boffins_vendor\classes\UserComponent',
            'identityClass' => 'frontend\models\UserDb',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
			'enableSession' => true,
			'authTimeout' => 21600, //6 hours 
			'absoluteAuthTimeout' => 86400, //24 hours 
			'on '.\yii\web\User::EVENT_BEFORE_LOGIN => ['frontend\models\UserDb', 'handleBeforeLogin'],
			'on '.\yii\web\User::EVENT_AFTER_LOGIN => ['frontend\models\UserDb', 'handleAfterLogin'],
			'on '.\yii\web\User::EVENT_BEFORE_LOGOUT => ['frontend\models\UserDb', 'handleBeforeLogout'],
			'on '.\yii\web\User::EVENT_AFTER_LOGOUT => ['frontend\models\UserDb', 'handleAfterLogout'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
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
		'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'en',
					'forceTranslation'=> true,
                    'fileMap' => [
                    //'main' => 'main.php',
                    ],
                ],
            ],
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

	'defaultRoute' => 'site/login',

    'params' => $params,
	'as beforeRequest' => [
		'class' => 'yii\filters\AccessControl',
		'rules' => [
			[
				'allow' => true,
				'actions' => ['login','customersignup','signup'],
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
				'roles' => ['@'],
			],
			/*[
				'allow' => true,
				'roles' => ['?'],
			],*/
		],
		'denyCallback' => function () {
			$comingFrom = ['project/view'];
			$comingFrom = $comingFrom[0] == 'site/login' || empty($comingFrom[0]) ? [Yii::$app->defaultRoute] : $comingFrom;
			Yii::$app->request->isPjax || Yii::$app->request->isAjax ? Yii::$app->session->set( 'comingFrom', [Yii::$app->defaultRoute] ) : Yii::$app->session->set( 'comingFrom', $comingFrom );
			return Yii::$app->response->redirect(['site/login', 'test' => 2]);
		},
	],

];




