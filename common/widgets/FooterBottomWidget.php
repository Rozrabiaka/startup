<?php

namespace common\widgets;

use yii\base\Widget;

class FooterBottomWidget extends Widget
{

	public function run()
	{
		return $this->render('footerBottom');
	}
}