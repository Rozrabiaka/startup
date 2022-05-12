<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property int $updated_at
 * @property string $img
 * @property string $description
 */
class NewPassword extends Model
{
	public $image;
	public $new_password;
	public $password_repeat;

	private $_user;


	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			['new_password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
			['new_password', 'required'],

			['password_repeat', 'required'],
			['password_repeat', 'compare', 'compareAttribute' => 'new_password', 'message' => 'Паролі не співпадають.'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'password_hash' => 'Пароль',
			'password_repeat' => 'Повторити пароль',
		];
	}

	/**
	 * Communities page.
	 *
	 * @return mixed
	 * @throws \yii\base\Exception
	 * @throws \yii\db\Exception
	 */
	public function updatePassword()
	{
		if (!$this->validate()) {
			return null;
		}

		$newPassword = \Yii::$app->security->generatePasswordHash($this->new_password);
		$result = Yii::$app->db->createCommand()
			->update('user', ['password_hash' => $newPassword], ['id' => Yii::$app->user->id])
			->execute();

		if (is_int($result)) return true;

		return false;
	}
}
