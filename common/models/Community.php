<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "community".
 *
 * @property int $id
 * @property string $name
 * @property string $img
 * @property string $date
 * @property int $status
 * @property int $community_access
 * @property int $community_his_add
 * @property int $user_id
 *
 * @property User $user
 */
class Community extends \yii\db\ActiveRecord
{
	public $image;
	protected const COMMUNITY_ACCESS_CLOSED = 0;
	protected const COMMUNITY_ACCESS_OPEN = 1;
	protected const COMMUNITY_HISTORY_ADD_ADMINISTRATOR = 0;
	protected const COMMUNITY_HISTORY_ADD_SUBSCRIBERS = 1;
	protected const COMMUNITY_HISTORY_ADD_ALL = 2;

	protected const COMMUNITY_DEACTIVATE = 0;
	protected const COMMUNITY_ACTIVE = 1;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'community';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name', 'img', 'community_access', 'community_his_add', 'description'], 'required'],
			[['date'], 'safe'],
			['image', 'safe'],
			[['status', 'community_access', 'community_his_add', 'user_id'], 'integer'],
			[['img'], 'string', 'max' => 255],
			[['description'], 'string', 'max' => 150, 'min' => 10],
			[['name'], 'string', 'max' => 30, 'min' => 3],
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
			'name' => "Назва спільноти",
			'img' => 'Картинка',
			'date' => 'Date',
			'status' => 'Status',
			'community_access' => 'Community Access',
			'community_his_add' => 'Community His Add',
			'user_id' => 'User ID',
			'description' => 'Опис спільноти',
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

	public function getRadioArrayCommunityAccess()
	{
		return array(
			self::COMMUNITY_ACCESS_OPEN => 'Відкрита спільнота',
			self::COMMUNITY_ACCESS_CLOSED => 'Закрита спільнота'
		);
	}

	public function getRadioArrayCommunityHistoryAdd()
	{
		return array(
			self::COMMUNITY_HISTORY_ADD_ADMINISTRATOR => 'Історії публікує тільки адміністратор',
			self::COMMUNITY_HISTORY_ADD_SUBSCRIBERS => 'Історії можуть публікувати підписники',
			self::COMMUNITY_HISTORY_ADD_ALL => 'Історії можуть публікувати усі користувачі'
		);
	}

	public function userCommunities()
	{
		$query = self::find()->select(['id', 'img', 'name'])->where(['user_id' => Yii::$app->user->id]);
		$queryCount = self::find()->where(['user_id' => Yii::$app->user->id])->count();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'totalCount' => $queryCount,
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
