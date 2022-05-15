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

	public function formName()
	{
		return '';
	}

	public function historis()
	{
		$query = History::find()
			->select(array(
				'history.id',
				'history.title',
				'history.user_id',
				'history.description',
				'history.datetime',
				'user.id as userId',
				'user.username',
				'user.img'
			))
			->leftJoin('user', 'history.user_id = user.id')
			->joinWith(['historyHashtags'])
			->groupBy(['history.id']);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 6
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