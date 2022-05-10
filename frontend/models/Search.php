<?php

namespace frontend\models;

use common\models\History;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ContactForm is the model behind the contact form.
 */
class Search extends Model
{
	public $q;
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['q'], 'string'],
		];
	}

	public function formName() {
		return '';
	}

	public function historis()
	{
		$query = History::find()
			->select(['history.id', 'history.title', 'history.user_id', 'history.description', 'history.datetime', 'user.username'])
			->joinWith('user')
			->joinWith('historyHashtags');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10
			],
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_DESC
				]
			],
		]);

		return $dataProvider;
	}
}