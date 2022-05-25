<?php

namespace frontend\models;

use claviska\SimpleImage;
use common\models\User;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Spatie\ImageOptimizer\Optimizers\Pngquant;
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
	 * @param integer $image
	 * @return mixed
	 * @throws \yii\db\Exception
	 */
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

	/**
	 * Communities page.
	 *
	 * @param integer $image
	 * @return mixed
	 */
	public function uploadAvatar($image)
	{
		$uploadPath = Yii::getAlias('@uploads') . '/avatars/' . date('Y') . '/' . date('m');
		$path = Yii::getAlias('@frontend') . '/web' . $uploadPath;
		if (!is_dir($path))
			mkdir($path, 0777, true);

		foreach ($image as $file) {
			$fileName = md5(microtime() . rand(0, 9999)) . '_' . $file->name;
			$imagePath = $path . '/' . $fileName;

			list($width) = getimagesize($file->tempName);

			if ($width > 200) {
				$image = new SimpleImage();
				// Magic! ✨
				$image
					->fromFile($file->tempName)
					->autoOrient()
					->resize(200)
					->toFile($file->tempName);
			}

			$optimizerChain = OptimizerChainFactory::create();
			$optimizerChain
				->addOptimizer(new Pngquant([
					9,
					'--force',
					'--skip-if-larger',
				]))
				->optimize($file->tempName, $imagePath);

			if (file_exists(Yii::getAlias('@frontend') . '/web' . Yii::$app->user->identity->img)
				and !empty(Yii::$app->user->identity->img)
				and Yii::$app->user->identity->img !== Yii::getAlias('@imgDefault')
			) {
				unlink(Yii::getAlias('@frontend') . '/web' . Yii::$app->user->identity->img);
			}

			return $uploadPath . '/' . $fileName;

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
