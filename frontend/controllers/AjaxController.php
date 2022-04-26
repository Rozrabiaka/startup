<?php

namespace frontend\controllers;

use Yii;
use common\models\Hashtags;
use yii\web\Controller;

class AjaxController extends Controller
{
	public function actionSearchHashtags()
	{
		if (Yii::$app->request->isAjax) {
			$hashtag = Yii::$app->request->get('hashtag');
			$searchResult = Hashtags::find()->select(['id', 'name'])->where(['like', 'name', trim($hashtag)])
				->asArray()
				->all();

			if (!empty($searchResult)) {
				return json_encode($searchResult);
			}
		}

		return false;
	}
}