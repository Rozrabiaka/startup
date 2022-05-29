<?php

namespace frontend\models;

use common\models\Images;
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
class FrontUser extends Model
{

	public $image;
	public $username;
	public $description;

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			['username', 'required'],
			['username', 'validationUsername'],
			['username', 'string', 'max' => 255],

			['image', 'safe'],

			[['description'], 'string', 'max' => 200],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'username' => 'Логін користувача',
			'email' => 'Пошта',
			'img' => 'Картинка',
			'description' => 'Опис',
		];
	}

	public function validationUsername($attribute, $params)
	{
		if (Yii::$app->user->identity->username !== $this->username) {
			$issetUser = User::find()->select(['id'])->where(['username' => $this->username])->one();
			if (!empty($issetUser))
				return $this->addError($attribute, 'Користувач з логіном "' . $this->username . '" вже існує.');
		}

		return true;
	}

	/**
	 * Communities page.
	 *
	 * @param array $image
	 * @return mixed
	 * @throws \yii\db\Exception
	 */
	public function updateUser($image)
	{
		if (!$this->validate()) {
			return null;
		}

		$this->image = Yii::$app->user->identity->img;
		if (!empty($image)) $this->image = Images::uploadAvatar($image);

		$result = Yii::$app->db->createCommand()
			->update('user', array(
				'img' => $this->image,
				'username' => $this->username,
				'description' => $this->description
			), array(
					'id' => Yii::$app->user->id
				)
			)->execute();

		if (is_int($result)) return true;

		return false;
	}

	public function getUserImage()
	{
		return Yii::$app->user;
	}

	public function getImagesLinks()
	{
		return array(
			$this->userImage->identity->img
		);
	}
}
