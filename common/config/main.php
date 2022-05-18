<?php
return [
	'aliases' => [
		'@bower' => '@vendor/bower-asset',
		'@npm' => '@vendor/npm-asset',
	],
	'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
	'components' => [
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'queue' => [
			'class' => \yii\queue\file\Queue::class,
			'path' => '@runtime/queue',
			'as log' => \yii\queue\LogBehavior::class,
		],
	],
	'modules' => [
		'debug' => [
			'class' => \yii\debug\Module::class,
			'panels' => [
				'queue' => \yii\queue\debug\Panel::class,
			],
		],
	],
	'bootstrap' => [
		'queue', // Компонент регистрирует свои консольные команды
	],
];
