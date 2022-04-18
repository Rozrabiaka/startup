<?php

namespace frontend\models;

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
	public $verifyCode;

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
			[['datetime'], 'safe'],
			[['email'], 'email'],
			[['verifyCode'], 'captcha'],
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
			'verifyCode' => "Опис",
		];
	}

	public function sendEmail()
	{
		return Yii::$app
			->mailer
			->compose(
				['html' => 'contactVerify-html', 'text' => 'contactVerify-text'],
				['name' => $this->name]
			)
			->setCharset('UTF-8')
			->setFrom([Yii::$app->params['supportEmail'] => 'Freedom Home - robot'])
			->setTo($this->email)
			->setSubject('Дякуємо за звернення')
			->send();
	}
}
