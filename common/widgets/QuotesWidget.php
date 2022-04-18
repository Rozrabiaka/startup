<?php

namespace common\widgets;

use common\models\Quote;
use yii\base\Widget;

class QuotesWidget extends Widget
{

	public function run()
	{
		$model = new Quote();
		$quote = $model::find()->select('*')->orderBy(['id' => SORT_DESC])->one();

		\Yii::$app->getView()->registerCssFile(\Yii::$app->request->baseUrl . '/css/quotes.css');
		\Yii::$app->getView()->registerJsFile(\Yii::$app->request->baseUrl . '/js/widget/quote.js',  ['position' => \yii\web\View::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
		return $this->render('quotes', [
			'quote' => $quote
		]);
	}
}