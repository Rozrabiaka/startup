<?php

namespace common\widgets;

use yii\bootstrap4\ButtonDropdown;
use yii\helpers\Html;
use yii\widgets\LinkSorter;

class SorterWidget extends LinkSorter
{
	protected $widgetAttributes;
	protected $links = array();
	public $label = 'Сортувати за';
	public $type = 'buttonDropDown';
	public $removeAttributes = array();

	protected function renderSortLinks()
	{
		$this->widgetAttributes = empty($this->attributes) ? array_keys($this->sort->attributes) : $this->attributes;

		$sort = \Yii::$app->request->getQueryParam('sort');
		foreach ($this->sort->attributes as $data) {
			if (!empty($data['asc'][$sort])) $this->label = $data['label'];
		}

		switch ($this->type) {
			case 'listStyleType':
				return $this->listStyleType();
			default:
				return $this->buttonDropDown();
		}
	}

	public function listStyleType()
	{
		foreach ($this->widgetAttributes as $name) {
			if (in_array($name, $this->removeAttributes)) continue;
			$this->links[] = $this->sort->link($name, ['tabindex' => '-1']);
		}

		return Html::ul($this->links, [
			'class' => 'list-group',
			'encode' => false,
		]);
	}

	public function buttonDropDown()
	{
		foreach ($this->widgetAttributes as $name) {
			if (in_array($name, $this->removeAttributes)) continue;
			$this->links[] = Html::tag('li', $this->sort->link($name, ['tabindex' => '-1']));
		}

		return ButtonDropdown::widget([
			'encodeLabel' => false,
			'label' => $this->label,
			'dropdown' => [
				'items' => $this->links,
			],
		]);
	}
}