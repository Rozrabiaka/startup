<?php

namespace common\widgets;

use Yii;
use yii\base\Widget;

class ProfileTopMenuWidget extends Widget
{

	public function run()
	{
		Yii::$app->user->identity->description = mb_strimwidth(Yii::$app->user->identity->description, 0, 130, '...');

		return $this->render('profileTopMenu',[
			'model' => Yii::$app->user
		]);
	}
}