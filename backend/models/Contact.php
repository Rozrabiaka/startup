<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $body
 * @property string $datetime
 */
class Contact extends \yii\db\ActiveRecord
{
	const EXPECTATION = 0;
	const VIEWED = 1;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'contact';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name', 'email', 'body'], 'required'],
			[['body'], 'string'],
			[['status'], 'integer'],
			[['datetime'], 'safe'],
			[['email'], 'email'],
			[['name'], 'string', 'max' => 255],
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
			'email' => "Пошта",
			'body' => "Опис",
			'status' => "Статус"
		];
	}

	public function getDropDown()
	{
		return [
			self::EXPECTATION => 'Очікування',
			self::VIEWED => 'Переглянуто'
		];
	}
}
