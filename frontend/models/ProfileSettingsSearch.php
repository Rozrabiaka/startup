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
		$this->q = Yii::$app->request->getQueryParam('q');
		$this->tag = (int)Yii::$app->request->getQueryParam('tag');
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

		//TODO оптимизировать
		if (empty($useId)) {
			$useId = Yii::$app->user->id;
		}

		$queryCount = History::find()->where(['history.user_id' => $useId]);
		$query->andWhere(['history.user_id' => $useId]);

		if (!empty($this->q)) {
			$queryCount->andWhere(['like', 'history.title', $this->q]);
			$query->andWhere(['like', 'history.title', $this->q]);
		}

		if (!empty($this->tag)) {
			$queryCount->andWhere(['=', 'hashtags.id', $this->tag]);
			$query->andWhere(['=', 'hashtags.id', $this->tag]);
		}

		$count = $queryCount->count('*');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'totalCount' => $count,
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