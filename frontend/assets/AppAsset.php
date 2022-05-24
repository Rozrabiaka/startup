<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

	public $css = [
		'css/site.css',
	];
	public $js = [
		['js/autocomplete-0.3.0.min.js', 'async' => 'async'],
		'js/jquery-ui.js',
		'js/lazy.min.js',
		'js/main.js',
	];

	public $images = [];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap4\BootstrapAsset',
	];
}
