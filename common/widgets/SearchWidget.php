<?php

namespace common\widgets;

use frontend\models\Search;
use yii\base\Widget;

class SearchWidget extends Widget
{

	public function run()
	{
		$model = new Search();

		return $this->render('search', array(
			'model' => $model
		));
	}
}