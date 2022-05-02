<?php

namespace common\widgets;

use Yii;
use yii\base\Widget;

class ProfileTopMenuWidget extends Widget
{

	public function run()
	{
		return $this->render('profileTopMenu',[
			'description' => mb_strimwidth(Yii::$app->user->identity->description, 0, 130, '...')
		]);
	}
}