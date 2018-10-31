<?php
$db = require(__DIR__ . '/db.php');
$db_backup = require(__DIR__ . '/db_backup.php');
$db_tenant = require(__DIR__ . '/db_tenant.php');
$db_backup_test = require(__DIR__ . '/db_backup_test.php');
$db_tenant_test = require(__DIR__ . '/db_tenant_test.php');
$db_test = require(__DIR__ . '/testDb.php');
$transport = require(__DIR__ . '/transport.php');

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
		],
		'db' => $db,
		'db_backup' => $db_backup,
		'db_tenant' => $db_tenant,
		'db_test' => $db_test,
		'db_backup_test' => $db_backup_test,
		'db_tenant_test' => $db_tenant_test, 
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //'useFileTransport' => true,
			'transport' => $transport,
        ],
		'global' => [
			'class' => 'boffins_vendor\classes\GlobalComponent',
		],
    ],
	'controllerMap' => [
		// Common migrations for the whole application
		'migrate' => [
			//'class' => 'yii\console\controllers\MigrateController'
			'class' => 'boffins_vendor\migration\SpecialMigration',
			//'migrationNamespaces' => ['console\migrations'],
			'migrationTable' => '{{%migration}}',
			'migrationPath' => 'console\migrations',
			'templateFile' => 'boffins_vendor\migration\special_migration_template.php',
		],
		// Migrations for testing only 
		'migrate-test' => [
			'class' => 'boffins_vendor\migration\SpecialMigration',
			//'migrationNamespaces' => ['common\tests\migrations'],
			'migrationTable' => '{{%migration}}',
			'migrationPath' => 'console\migrations',
			//'db' => $db_test,
			'templateFile' => 'boffins_vendor\migration\special_migration_template.php',
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
