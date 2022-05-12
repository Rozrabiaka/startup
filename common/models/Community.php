<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "community".
 *
 * @property int $id
 * @property string $name
 * @property string $img
 * @property string $date
 */
class Community extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'community';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name', 'img'], 'required'],
			[['date'], 'safe'],
			[['name', 'img'], 'string', 'max' => 255],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => "Ім'я",
			'img' => 'Картинка',
			'date' => 'Дата',
		];
	}

	public function getCommunities()
	{
		$query = self::find();

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
