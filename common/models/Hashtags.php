<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hashtags".
 *
 * @property int $id
 * @property string $name
 * @property string|null $date
 */
class Hashtags extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'hashtags';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['date'], 'safe'],
			[['status'], 'integer'],
			[['name'], 'string', 'max' => 255],
			[['name'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Тег',
			'date' => 'Дата',
			'status' => 'Статус'
		];
	}

	public static function validateHashtag($tag)
	{
		$tag = preg_replace("/[^a-zA-ZА-Яа-я0-9\s+]/", '', $tag);
		if (preg_match('/[^0-9]/', $tag) === 0) $tag = null;

		return ucfirst(strtolower($tag));
	}
}
