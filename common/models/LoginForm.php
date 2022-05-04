<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
	public $username;
	public $password;
	public $rememberMe = true;

	private $_user;

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			// username and password are both required
			[['username', 'password'], 'required'],
			// rememberMe must be a boolean value
			['rememberMe', 'boolean'],
			// password is validated by validatePassword()
			['password', 'validatePassword'],
		];
	}

	/**
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 */
	public function validatePassword($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$user = $this->getUserByEmail();
			if (empty($user)) $user = $this->getUser();
			if (!$user || !$user->validatePassword($this->password)) {
				$this->addError($attribute, 'Невірний логін чи пароль.');
			}
		}
	}

	public function attributeLabels()
	{
		return [
			'username' => 'Логін',
			'password' => 'Пароль',
			'rememberMe' => "Запам'ятати мене"
		];
	}

	/**
	 * Logs in a user using the provided username and password.
	 *
	 * @return bool whether the user is logged in successfully
	 */
	public function login()
	{
		if ($this->validate()) {
			$user = $this->getUserByEmail();
			if (empty($user)) $user = $this->getUser();

			return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
		}

		return false;
	}

	/**
	 * Finds user by [[username]]
	 *
	 * @return User|null
	 */
	protected function getUser()
	{
		if ($this->_user === null) {
			$this->_user = User::findByUsername($this->username);
		}

		return $this->_user;
	}

	protected function getUserByEmail()
	{
		if ($this->_user === null) {
			$this->_user = User::findByEmail($this->username);
		}

		return $this->_user;
	}

	public function adminLogin()
	{
		if ($this->validate()) {
			$user = $this->getUser();
			if ($user->admin_login == User::ADMIN_LOGIN) {
				return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
			}
		}

		return false;
	}
}
