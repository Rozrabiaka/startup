<?php

namespace frontend\models;

use common\models\History;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ContactForm is the model behind the contact form.
 */
class ProfileSettingsSearch extends Model
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

	public function __construct()
	{
		$this->q = Yii::$app->request->getQueryParam('q');
	}

	public function formName()
	{
		return '';
	}

	public function search($useId = null)
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
			->joinWith('historyHashtags')
			->groupBy(['history.id']);

		if (empty($useId)) $query->where(['history.user_id' => Yii::$app->user->id]);
		else $query->where(['history.user_id' => $useId]);

		if (!empty($this->q)) $query->andWhere(['like', 'history.title', $this->q]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 5
			],
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_DESC
				]
			],
		]);

		return $dataProvider;
	}

	public function getPostById($id)
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
			->joinWith('historyHashtags')
			->where(['history.id' => $id])
			->one();

		return $query;
	}
}