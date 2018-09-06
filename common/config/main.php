<?php
$db = require(__DIR__ . '/db.php');
$db_backup = require(__DIR__ . '/db_backup.php');
$db_tenant = require(__DIR__ . '/db_tenant.php');
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
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
            'useFileTransport' => false,
			'transport' => $transport,
        ],
		'global' => [
			'class' => 'boffins_vendor\classes\GlobalComponent',
		]
    ],
];
