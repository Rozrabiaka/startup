<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "traitors".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $img
 * @property integer $active
 */
class Traitors extends \yii\db\ActiveRecord
{
	public $image;

	const NOT_ACTIVE = 0;
	const ACTIVE = 1;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'traitors';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name', 'description', 'img', 'insult'], 'required'],
			[['description'], 'string'],
			[['feedback_email'], 'email'],
			[['active'], 'integer'],
			[['name', 'img', 'insult'], 'string', 'max' => 255],
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
			'description' => 'Опис',
			'img' => 'Картинка',
			'insult' => 'Поганяло/Клікуха',
			'feedback_email' => 'Ваша пошта'
		];
	}

	public function getImageDefaultLink()
	{
		return '/images/no-image.png';
	}

	public function getActiveDropDown()
	{
		return array(
			self::ACTIVE => 'Активний',
			self::NOT_ACTIVE => 'Неактивний'
		);
	}

	public function uploadImages()
	{
		$uploadPath = Yii::getAlias('@uploads') . '/traitors/' . date('Y') . '/' . date('m');
		$path = Yii::getAlias('@frontend') . '/web' . $uploadPath;
		if (!is_dir($path))
			mkdir($path, 0777, true);

		$paths = array();
		foreach ($this->image as $file) {
			$fileName = md5(microtime() . rand(0, 9999)) . '_' . $file->name;
			$imagePath = $path . '/' . $fileName;
			if ($file->saveAs($imagePath)) {
				$paths[] = $uploadPath . '/' . $fileName;
			}
		}

		if (!empty($paths)) return $paths;

		return false;
	}

	public function getLinks()
	{
		return $this->hasMany(self::className(), ['id' => 'id']);
	}

	public function getImagesLinks()
	{
		return ArrayHelper::getColumn($this->links, 'img');
	}

	public function getImagesLinksData()
	{
		return ArrayHelper::toArray($this->links, [
			self::className() => [
				'key' => 'id'
			]
		]);
	}

	public function sendEmail()
	{
		return Yii::$app
			->mailer
			->compose(
				['html' => 'createTraitor-html', 'text' => 'createTraitor-text']
			)
			->setCharset('UTF-8')
			->setFrom([Yii::$app->params['supportEmail'] => 'Traitors - robot'])
			->setTo($this->feedback_email)
			->setSubject('Traitors. Дякуємо за допомогут.')
			->send();
	}
}
