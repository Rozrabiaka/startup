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
	public $css = [
		'css/site.css',
	];
	public $js = [
		'js/footer.js',
		'js/main.js',
		'js/autocomplete-0.3.0.min.js',
		'js/jquery-ui.js'
	];
	public $images = [];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap4\BootstrapAsset',
	];
}
