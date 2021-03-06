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
	/* userInfo in search model frontend/search */
	public $username;
	public $img;
	public $userId;

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
			[['title', 'user_id'], 'required'],
			['hashtags', 'validateHashtags', 'skipOnEmpty' => false, 'skipOnError' => false],
			[['description'], 'validateDescription'],
			[['user_id'], 'integer'],
			[['datetime'], 'safe'],
			[['title'], 'string', 'max' => 255],
			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
		];
	}

	public function init()
	{
		$this->user_id = Yii::$app->user->id;
		parent::init();
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
		} else if (iconv_strlen($this->description) < 150) {
			$this->addError('description', "Мінімальная кількість символів має бути 150.");
		}
	}

	public function validateHashtags()
	{
		$hashtagsData = json_decode($this->hashtags);
		if (!is_array($hashtagsData) || json_last_error() !== JSON_ERROR_NONE) {
			//TODO валидацию что если введут только символы -> и хештег меньше 3 букв значит что то не то
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
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

	public function getHistoryHashtags()
	{
		return $this->hasMany(HistoryHashtags::className(), ['history_id' => 'id'])
			->select(['hashtag_id', 'history_id', 'hashtags.name as hashtagName'])
			->leftJoin('hashtags', 'history_hashtags.hashtag_id = hashtags.id');
	}

	public function saveHistory()
	{
		if (!empty($this->hashtags) && $hashtags = json_decode($this->hashtags)) {
			$hashtagsIds = array();
			foreach ($hashtags as $data) {
				//валидация хештега
				$id = Hashtags::validateId($data->tagId);
				if (!empty($id)) array_push($hashtagsIds, $id);
			}

			preg_match_all('/<img[^>]+>/i', $this->description, $descriptionImages);

			foreach ($descriptionImages[0] as $key => $images) {
				$explode = explode('/', $images);
				$transferResult = Images::transferImage(str_replace('">', '', $explode[array_key_last($explode)]));

				if (!empty($transferResult)) {
					$this->description = str_replace($transferResult['oldFilePath'], $transferResult['newFilePath'], $this->description);
				}
			}

			//change src to data-src, for lazy load
			$this->description = str_replace('src', 'data-src', $this->description);

			if ($this->save()) {
				//сохраняем в таблицу postHashtags массив с тегами $hashtagsIds
				if (!empty($hashtagsIds)) {
					$historyBatchArray = array();
					foreach ($hashtagsIds as $id) {
						$historyBatchArray[] = array(
							'history_id' => $this->id,
							'hashtag_id' => $id
						);
					}

					Yii::$app->db->createCommand()->batchInsert(HistoryHashtags::tableName(),
						['history_id', 'hashtag_id'], $historyBatchArray)->execute();
				}
			}
			return true;
		}

		return false;
	}

	public function updateHistory()
	{
		if (!empty($this->hashtags) && $hashtags = json_decode($this->hashtags)) {
			$hashtagsIds = array();
			foreach ($hashtags as $data) {
				if (!$data->current) {
					$id = Hashtags::validateId($data->tagId);
					if (!empty($id)) array_push($hashtagsIds, $id);
				}
			}

			preg_match_all('/<img[^>]+>/i', $this->description, $descriptionImages);

			foreach ($descriptionImages[0] as $key => $images) {
				$explode = explode('/', $images);
				$transferResult = Images::transferImage(str_replace('">', '', $explode[array_key_last($explode)]));
				if (!empty($transferResult)) {
					$this->description = str_replace($transferResult['oldFilePath'], $transferResult['newFilePath'], $this->description);
				}
			}

			//change src to data-src, for lazy load
			$this->description = str_replace('src', 'data-src', $this->description);

			if ($this->save()) {
				//сохраняем в таблицу postHashtags массив с тегами $hashtagsIds
				if (!empty($hashtagsIds)) {
					$historyBatchArray = array();
					foreach ($hashtagsIds as $id) {
						$historyBatchArray[] = array(
							'history_id' => $this->id,
							'hashtag_id' => $id
						);
					}

					Yii::$app->db->createCommand()->batchInsert(HistoryHashtags::tableName(),
						['history_id', 'hashtag_id'], $historyBatchArray)->execute();
				}
			}
			return true;
		}

		return false;
	}
}
