<?php
$redis = require(__DIR__ . '/redis.php');
return [
    'id' => 'app-common-tests',
    'basePath' => dirname(__DIR__),
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
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
        ],
		'redis' => $redis,
		'activityManager' => [
				'class' => 'boffins_vendor\classes\ActivityManager'
			],
	         
		'db' => require(__DIR__ . '/testDb.php'),
    ],
];
