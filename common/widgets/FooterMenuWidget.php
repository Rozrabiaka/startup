<?php

namespace common\widgets;

use yii\base\Widget;

class FooterMenuWidget extends Widget
{

	public function run()
	{
		return $this->render('footerMenu');
	}
}