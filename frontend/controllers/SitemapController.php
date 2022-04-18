<?php

namespace frontend\controllers;

use backend\models\Traitors;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SitemapController extends Controller
{

	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				//'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function actionSitemap()
	{

		$date = (new \DateTime('Europe/Kiev'))->format('Y-m-d\TH:i:sP');
		$xmldata = '<?xml version="1.0" encoding="utf-8"?>';
		$xmldata .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xmlns:xhtml="http://www.w3.org/1999/xhtml"
        xsi:schemaLocation=" http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
		$traitors = Traitors::find()->select('id')->asArray()->all();

		$xmldata .= '<url>';
		$xmldata .= '<loc>' . Yii::$app->request->hostInfo . '</loc>';
		$xmldata .= '<lastmod>' . $date . '</lastmod>';
		$xmldata .= '<changefreq>daily</changefreq>';
		$xmldata .= '<priority>1.0000</priority>';
		$xmldata .= '</url>';

		foreach ($traitors as $data) {
			$xmldata .= '<url>';
			$xmldata .= '<loc>' . Yii::$app->request->hostInfo . '/site/traitor/' . $data['id'] . '</loc>';
			$xmldata .= '<lastmod>' . $date . '</lastmod>';
			$xmldata .= '<changefreq>daily</changefreq>';
			$xmldata .= '<priority>0.8000</priority>';
			$xmldata .= '</url>';
		}

		$rules = Yii::$app->urlManager->rules;
		foreach ($rules as $rule) {
			if (str_contains($rule->route, 'site')) {
				$patterns = explode('|', $rule->pattern);
				$lastKey = $patterns[array_key_last($patterns)];
				$patterns[array_key_last($patterns)] = str_replace(")$#u", "", $lastKey);
				unset($patterns[0]);
				foreach ($patterns as $pattern) {
					$xmldata .= '<url>';
					$xmldata .= '<loc>' . Yii::$app->request->hostInfo . '/' . $pattern . '</loc>';
					$xmldata .= '<lastmod>' . $date . '</lastmod>';
					$xmldata .= '<changefreq>daily</changefreq>';
					$xmldata .= '<priority>0.8000</priority>';
					$xmldata .= '</url>';
				}
			}
		}

		$xmldata .= '</urlset>';

		file_put_contents('sitemap.xml', $xmldata);
		exit;
	}
}
