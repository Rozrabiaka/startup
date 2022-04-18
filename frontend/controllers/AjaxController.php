<?php

namespace frontend\controllers;

use common\models\Quote;
use yii\helpers\Json;
use yii\web\Controller;

class AjaxController extends Controller
{
	public function actionQuote()
	{
		if (\Yii::$app->request->isAjax) {
			$id = (int)\Yii::$app->request->getQueryParam('id');
			$model = new Quote();
			$quote = $model::find()->select('*')->where(['id' => $id])->one();

			if (!empty($quote)) {
				return JSON::encode([
					'success' => true,
					'data' => array(
						'id' => $quote->id,
						'text' => $quote->text,
						'author' => $quote->author
					)
				]);
			}
		}

		return JSON::encode([
			'success' => false,
			'message' => 'Щось пішло не так.',
		]);
	}

}