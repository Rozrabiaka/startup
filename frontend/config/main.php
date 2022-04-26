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
	'components' => [
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
				'username' => 'traitorsua@gmail.com',
				'password' => 'p1buny5og43fs0lt',
				'port' => '587',
				'encryption' => 'tls',
			],
		],
		'authClientCollection' => [
			'class' => \yii\authclient\Collection::className(),
			'clients' => [
				'google' => [
					'class' => 'yii\authclient\clients\Google',
					'clientId' => '256585557761-d0ch4pn82ep6pii485n7eteb43e80fft.apps.googleusercontent.com',
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
				'<action:index>' => 'profile/<action>',
				'<action:index|contact|signup|login|request-password-reset|resend-verification-email>' => 'site/<action>',
			],
		],
	],
	'params' => $params,
];
