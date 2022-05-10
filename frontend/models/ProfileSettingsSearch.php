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
			->select(['history.id', 'history.title', 'history.user_id', 'history.description', 'history.datetime'])
			->joinWith('user')
			->joinWith('historyHashtags');

		if (empty($useId)) $query->where(['history.user_id' => Yii::$app->user->id]);
		else $query->where(['history.user_id' => $useId]);

		if (!empty($this->q)) $query->andWhere(['like', 'history.title', $this->q]);

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

	public function getPostById($id)
	{
		$query = History::find()
			->select(['history.*'])
			->joinWith('user')
			->joinWith('historyHashtags')
			->where(['history.id' => $id])
			->one();

		return $query;
	}
}