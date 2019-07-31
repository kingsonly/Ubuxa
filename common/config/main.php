<?php
$db = require(__DIR__ . '/db.php');
$db_backup = require(__DIR__ . '/db_backup.php');
$db_tenant = require(__DIR__ . '/db_tenant.php');
$db_backup_test = require(__DIR__ . '/db_backup_test.php');
$db_tenant_test = require(__DIR__ . '/db_tenant_test.php');
$db_test = require(__DIR__ . '/testDb.php');
$transport = require(__DIR__ . '/transport.php');
$redis = require(__DIR__ . '/redis.php');

return [
	'name' => 'Ubuxa',
	'language' => 'en-GB',
	'sourceLanguage' => 'en-GB',
	'timeZone' => 'Africa/Lagos',
	'bootstrap' => [
					'queue', 
					'log',
					'activityManager'
					
					],
    'aliases' => [
        '@bower' => '@vendor/bower',
        '@npm'   => '@vendor/npm',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
		],
		'api' => [
				'class' => 'common\components\Api',
			],
		'db' => $db,
		'db_backup' => $db_backup,
		'db_tenant' => $db_tenant,
		'db_test' => $db_test,
		'db_backup_test' => $db_backup_test,
		'db_tenant_test' => $db_tenant_test, 
		'redis' => $redis,
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
			//'transport' => $transport,
        ],
		'global' => [
			'class' => 'boffins_vendor\classes\GlobalComponent',
		],
		'activityManager' => [
				'class' => 'boffins_vendor\classes\ActivityManager'
			],
	          'redis' => [
            'class' => \yii\redis\Connection::class,
            // ...

            // retry connecting after connection has timed out
            // yiisoft/yii2-redis >=2.0.7 is required for this.
            'retries' => 1,
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
    ],
	'controllerMap' => [
		// Common migrations for the whole application
		'migrate' => [
			//'class' => 'yii\console\controllers\MigrateController',
			'class' => 'boffins_vendor\migration\SpecialMigration',
			//'migrationNamespaces' => ['console\migrations'],
			'migrationTable' => '{{%migration}}',
			'migrationPath' => 'console/migrations',
			'templateFile' => 'boffins_vendor/migration/special_migration_template.php',
		],
		// Migrations for testing only 
		'migrate-test' => [
			'class' => 'boffins_vendor\migration\SpecialMigration',
			//'migrationNamespaces' => ['common\tests\migrations'],
			'migrationTable' => '{{%migration}}',
			'migrationPath' => 'console/migrations',
			//'db' => $db_test,
			'templateFile' => 'boffins_vendor/migration/special_migration_template.php',
			'db_suffix' => '_test',
		],
		// Migrations for testing only 
		'migrate-start' => [
			'class' => 'boffins_vendor\migration\SpecialMigration',
			'migrationNamespaces' => ['common\start\migrations'],
			'migrationTable' => '{{%migration}}',
			'migrationPath' => null,
		],
		// Migrations for testing only 
		'migrate-start-test' => [
			'class' => 'boffins_vendor\migration\SpecialMigration',
			'migrationNamespaces' => ['common\start\test\migrations'],
			'migrationTable' => '{{%migration}}',
			'migrationPath' => null,
			//'db' => $db_test,
			'db_suffix' => '_test',
		],
	],
];
