<?php

namespace common\widgets;

use yii\bootstrap4\ButtonDropdown;
use yii\helpers\Html;
use yii\widgets\LinkSorter;

class SorterDropdown extends LinkSorter
{
	public $label = 'Сортувати за';
	protected function renderSortLinks()
	{
		$attributes = empty($this->attributes) ? array_keys($this->sort->attributes) : $this->attributes;

		$links = array();
		foreach ($attributes as $name) {
			if ($name == 'id' || $name == 'description' || $name == 'user_id') continue;

			$links[] = Html::tag('li', $this->sort->link($name, ['tabindex' => '-1']));
		}


		$sort = \Yii::$app->request->getQueryParam('sort');
		foreach ($this->sort->attributes as $data) {
			if (!empty($data['asc'][$sort])) $this->label = $data['label'];
		}

		return ButtonDropdown::widget([
			'encodeLabel' => false,
			'label' => $this->label,
			'dropdown' => [
				'items' => $links,
			],
		]);
	}
}