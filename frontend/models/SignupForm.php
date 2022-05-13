<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
	public $username;
	public $email;
	public $password;
	public $img;
	public $description;


	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			['username', 'trim'],
			['username', 'required'],
			['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Це ім’я користувача вже зайнято.'],
			['username', 'string', 'min' => 2, 'max' => 255],

			['img', 'string'],
			['description', 'string'],

			['email', 'trim'],
			['email', 'required'],
			['email', 'email'],
			['email', 'string', 'max' => 255],
			['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Цю електронну адресу вже зайнято.'],

			['password', 'required'],
			['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
		];
	}

	public function attributeLabels()
	{
		return [
			'username' => 'Логін',
			'email' => 'Пошта',
			'password' => "Пароль",
			'img' => 'Аватар'
		];
	}

	/**
	 * Signs user up.
	 *
	 * @return bool whether the creating new account was successful and email was sent
	 */
	public function signup()
	{
		if (!$this->validate()) {
			return null;
		}

		$user = new User();
		$user->username = $this->username;

		$user->email = $this->email;
		$user->description = '';
		$user->status = 10;
		$user->img = Yii::getAlias('@imgDefault');
		$user->setPassword($this->password);
		$user->generateAuthKey();
		$user->generateEmailVerificationToken();

		if ($user->save()) {
			Yii::$app->user->login($user);
			return true;
		}
		
		return false;
		//&& $this->sendEmail($user);
	}

	/**
	 * Sends confirmation email to user
	 * @param User $user user model to with email should be send
	 * @return bool whether the email was sent
	 */
	protected function sendEmail($user)
	{
		return Yii::$app
			->mailer
			->compose(
				['html' => 'successSignup-html', 'text' => 'successSignup-text'],
				['user' => $user]
			)
			->setFrom([Yii::$app->params['supportEmail'] => 'Freedom Home robot'])
			->setTo($this->email)
			->setSubject('Реєстрація аккаунта ' . Yii::$app->name)
			->send();
	}
}
