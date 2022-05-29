<?php
$params = array_merge(
	require __DIR__ . '/../../common/config/params.php',
	require __DIR__ . '/../../common/config/params-local.php',
	require __DIR__ . '/params.php',
	require __DIR__ . '/params-local.php'
);

return [
	'id' => 'app-frontend',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'language' => 'uk',
	'controllerNamespace' => 'frontend\controllers',
	'modules' => [
		'comment' => [
			'class' => 'yii2mod\comments\Module',
		],
	],
	'components' => [
		'i18n' => [
			'translations' => [
				'yii2mod.comments' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@yii2mod/comments/messages',
				],
			],
		],
		'assetManager' => array(
			'linkAssets' => true,
			'appendTimestamp' => true,
		),
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			'viewPath' => '@common/mail',
			'useFileTransport' => false,
			'transport' => [
				'class' => 'Swift_SmtpTransport',
				'host' => 'smtp.gmail.com',
				'username' => 'freehomeua@gmail.com',
				'password' => '4.vqJAN(cQ%ZWj96',
				'port' => '587',
				'encryption' => 'tls',
			],
		],
		'authClientCollection' => [
			'class' => \yii\authclient\Collection::className(),
			'clients' => [
				'google' => [
					'class' => 'yii\authclient\clients\Google',
					'clientId' => '376858153683-5csopdh89kqf21gfkh4uac4s8llnl085.apps.googleusercontent.com',
					'clientSecret' => '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',
				],
			],
		],
		'request' => [
			'baseUrl' => '',
			'csrfParam' => '_csrf-frontend',
		],
		'user' => [
			'identityClass' => 'common\models\User',
			'enableAutoLogin' => true,
			'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
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
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<action:index|comments|communities|contact|signup|login|request-password-reset|resend-verification-email|create-community>' => 'site/<action>',
			],
		],
	],
	'params' => $params,
];
