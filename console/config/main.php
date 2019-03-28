<?php
$db = require(__DIR__ . '/db.php');
$db_backup = require(__DIR__ . '/db_backup.php');
$db_tenant = require(__DIR__ . '/db_tenant.php');
$db_test = require(__DIR__ . '/testDb.php');
$transport = require(__DIR__ . '/transport.php');
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
					'queue', 
					'log'
					],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
    ],
    'components' => [
        'log' => [ 
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'settingscomponent' => [
            'class' => 'frontend\settings\components\SettingsComponent',
        ],

		'queue' => [
            'class' => \yii\queue\redis\Queue::class,
		    'as log' => \yii\queue\LogBehavior::class,
            'redis' => 'redis', // Redis connection component or its config
            'channel' => 'queue', // Queue channel key
        ],
	    'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],

		'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
			'transport' => $transport,
		],
		/*'db' => $db,
		'db_backup' => $db_backup,
		'db_tenant' => $db_tenant, 
		'db_test' => $db_test,*/

    ],
    'params' => $params,
];
