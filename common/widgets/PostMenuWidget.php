<?php

namespace common\widgets;

use yii\base\Widget;

class PostMenuWidget extends Widget
{
	public $pathInfo;
	public $postId;

	public function run()
	{
		$links = array();

		//в будущем добавить линку для ЛЮБОГО постав АДМИНКУ ИЛИ МОДЕРУ заблокировать пост через ajax!
		switch ($this->pathInfo) {
			case 'profile/my-history':
				$links = array(
					'Редагувати' => '/profile/edit-history?id=' . $this->postId
				);
				break;
			default:
				break;
		}

		return $this->render('postMenu', [
			'links' => $links
		]);
	}
}