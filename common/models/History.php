<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $user_id
 * @property string|null $datetime
 *
 * @property User $user
 */
class History extends \yii\db\ActiveRecord
{

	public $hashtags;

	const STATUS_ACTIVE = 0;
	const STATUS_DEACTIVATED = 1;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'history';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['title', 'user_id', 'hashtags'], 'required'],
			[['description'], 'validateDescription'],
			[['user_id'], 'integer'],
			[['datetime'], 'safe'],
			[['hashtags'], 'validateHashtags'],
			[['title'], 'string', 'max' => 255],
			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'title' => 'Титулка',
			'description' => 'Історія',
			'user_id' => 'User ID',
			'datetime' => 'Дата',
			'hashtags' => 'Хештеги'
		];
	}

	public function validateDescription()
	{
		if ($this->description == '<p>&nbsp;</p>') {
			$this->addError('description', "Поле обов'язкове для заповнення.");
		} else if (iconv_strlen($this->description) < 200) {
			$this->addError('description', "Мінімальная кількість символів має бути 200.");
		}
	}

	public function validateHashtags()
	{
		$hashtagsData = json_decode($this->hashtags);
		if (json_last_error() !== JSON_ERROR_NONE) {
			$this->hashtags = '';
			$this->addError('hashtags', "Трапилась незроуміла помилка. Спробуйте знову.");
		}

		if (!is_array($hashtagsData)) {
			$this->hashtags = '';
			$this->addError('hashtags', "Поле обов'язкове для заповнення.");
		}
	}

	/**
	 * Gets query for [[User]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id'])->select(['id', 'username', 'img']);
	}

	public function getHistoryHashtags()
	{
		return $this->hasMany(HistoryHashtags::className(), ['history_id' => 'id'])->select(['hashtag_id', 'history_id'])->joinWith('hashtag');
	}

	public function transferImage($fromImage)
	{
		$filePath = Yii::getAlias('@frontend') . '/web/uploads/removeImages/' . $fromImage;
		$destinationFilePath = Yii::getAlias('@frontend') . '/web/uploads/historyFiles/';

		if (shell_exec("cp -r $filePath $destinationFilePath")) {
			return false;
		} else {
			if (file_exists($filePath))
				unlink($filePath);
		}

		return array(
			'newFilePath' => Yii::$app->request->hostInfo . '/uploads/historyFiles/' . $fromImage,
			'oldFilePath' => Yii::$app->request->hostInfo . '/uploads/removeImages/' . $fromImage
		);
	}
}
