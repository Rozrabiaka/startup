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
			$ignore = Yii::$app->request->get('ignore');

			$q = Hashtags::find()->select(['id', 'name'])->where(['like', 'name', trim($hashtag)]);

			if (!empty($ignore)) {
				$explodeIgnore = explode(',', $ignore);
				foreach ($explodeIgnore as $explode) {
					$q->andWhere(['!=', 'name', trim($explode)]);
				}
			}

			$searchResult = $q->asArray()->all();

			if (!empty($searchResult)) {
				return json_encode($searchResult);
			}
		}

		return false;
	}

	public function actionSearch()
	{
		if (Yii::$app->request->isAjax) {
			$q = Yii::$app->request->get('q');

			$historyResult = (new \yii\db\Query())
				->select(['title', 'id'])
				->from('history')
				->where(['like', 'title', $q])
				->limit(10)
				->all();

			$hashtagsResult = (new \yii\db\Query())
				->select(['name', 'id'])
				->from('hashtags')
				->where(['like', 'name', $q])
				->limit(10)
				->all();

			return json_encode(array(
				'data' => array(
					'history' => $historyResult,
					'hashtags' => $hashtagsResult
				)
			));
		}

		return false;
	}
}