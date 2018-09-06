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
        	'class' => 'frontend\settings\components\Settingsdate',
    	],
		'i18n' => [
        'translations' => [
            'app*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                //'basePath' => '@app/messages',
                //'sourceLanguage' => 'en-US',
                'fileMap' => [
                    'app' => 'app.php',
                    'app/error' => 'error.php',
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
	],

	'defaultRoute' => 'site/login',

    'params' => $params,
	'as beforeRequest' => [
		'class' => 'yii\filters\AccessControl',
		'rules' => [
			[
				'allow' => true,
				//'controllers' =>['project'],
				'actions' => ['login'],
				'roles' => ['?'],
			],
			[
				'allow' => true,
				'controllers' =>['api/project'],
				
				  
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




