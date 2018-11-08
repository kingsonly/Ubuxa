<?php

return [
    'components' => [
    ],
	'controllerMap' => [
		// Common migrations for the whole application
		'migrate' => [
			//'class' => 'yii\console\controllers\MigrateController'
			'class' => 'boffins_vendor\migration\SpecialMigration',
			//'migrationNamespaces' => ['console\migrations'],
			'migrationTable' => '{{%migration}}',
			'migrationPath' => 'console/migrations',
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
