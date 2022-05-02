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

			[['description'], 'string'],
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

	public function updateUser($image)
	{
		if (!$this->validate()) {
			return null;
		}

		$this->image = Yii::$app->user->identity->img;
		if (!empty($image)) $this->image = $this->uploadAvatar($image);

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

	public function uploadAvatar($image)
	{
		$uploadPath = Yii::getAlias('@uploads') . '/avatars/' . date('Y') . '/' . date('m');
		$path = Yii::getAlias('@frontend') . '/web' . $uploadPath;
		if (!is_dir($path))
			mkdir($path, 0777, true);

		foreach ($image as $file) {
			$fileName = md5(microtime() . rand(0, 9999)) . '_' . $file->name;
			$imagePath = $path . '/' . $fileName;

			if ($file->saveAs($imagePath)) {
				if (file_exists(Yii::getAlias('@frontend') . '/web' . Yii::$app->user->identity->img)
					and !empty(Yii::$app->user->identity->img)
					and Yii::$app->user->identity->img !== Yii::getAlias('@imgDefault')
				) {
					unlink(Yii::getAlias('@frontend') . '/web' . Yii::$app->user->identity->img);
				}

				return $uploadPath . '/' . $fileName;
			}
		}

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
