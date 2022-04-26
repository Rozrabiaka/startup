<?php

namespace common\widgets;

use yii\base\Widget;

class ProfileMenuWidget extends Widget
{

	public function run()
	{
		return $this->render('profileMenu');
	}
}