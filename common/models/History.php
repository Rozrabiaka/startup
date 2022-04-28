<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

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
			[['title', 'description', 'user_id', 'hashtags'], 'required'],
			[['description'], 'string'],
			[['user_id'], 'integer'],
			[['datetime'], 'safe'],
			[['hashtags'], 'string'],
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
			'datetime' => 'Date',
		];
	}

	/**
	 * Gets query for [[User]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

	public function getHistoryHashtags()
	{
		return $this->hasMany(HistoryHashtags::className(), ['history_id' => 'id'])->joinWith('hashtag');
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

	public function historis()
	{
		$query = self::find()
			->select(['history.id', 'history.title', 'history.user_id', 'history.description', 'history.datetime', 'user.username'])
			->joinWith('user')
			->joinWith('historyHashtags');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10
			],
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_DESC
				]
			],
		]);

		return $dataProvider;

	}
}
