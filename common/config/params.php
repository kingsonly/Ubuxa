<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
	'request_id' => '',
	'actionToModelEventMap' => [
		'index' => 'find',
		'view' => 'find',
		'create' => 'insert',
		'update' => 'update',
		'delete' => 'delete', 'softdelete'
	],
];
