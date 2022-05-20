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
	public $history;
	public $tag;

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['q'], 'string'],
		];
	}

	public function __construct()
	{
		$this->q = trim((string)\Yii::$app->getRequest()->getQueryParam('q'));
		if (!empty(\Yii::$app->getRequest()->getQueryParam('history')))
			$this->history = trim((int)\Yii::$app->getRequest()->getQueryParam('history'));
		if (\Yii::$app->getRequest()->getQueryParam('tag'))
			$this->tag = trim(\Yii::$app->getRequest()->getQueryParam('tag'));
	}

	public function formName()
	{
		return '';
	}

	public function histories()
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

		if (!empty($this->q)) $query->andWhere(['like', 'history.title', $this->q]);
		if (!empty($this->history)) $query->andWhere(['history.id' => $this->history]);
		if (!empty($this->tag)) $query->andWhere(['hashtags.id' => $this->tag]);

		$queryCount = History::find()->count('id');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'totalCount' => $queryCount,
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