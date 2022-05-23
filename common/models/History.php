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

	public function transferImage($fromImage)
	{
		$dateFolder = date('Y') . '/' . date('m');
		$filePath = Yii::getAlias('@frontend') . '/web/uploads/removeImages/' . $fromImage;
		$destinationFilePath = Yii::getAlias('@frontend') . '/web/uploads/historyFiles/' . $dateFolder;

		if (!file_exists($destinationFilePath)) {
			mkdir($destinationFilePath, 0755, true);
		}

		shell_exec("cp -r $filePath $destinationFilePath");

		if (file_exists($filePath))
			unlink($filePath);

		return array(
			'newFilePath' => Yii::$app->request->hostInfo . '/uploads/historyFiles/' . $dateFolder . '/' . $fromImage,
			'oldFilePath' => Yii::$app->request->hostInfo . '/uploads/removeImages/' . $fromImage
		);
	}

	public function saveHistory()
	{
		if (!empty($this->hashtags) && $hashtags = json_decode($this->hashtags)) {
			//делаем одномерный массив для поиска одним запросом
			$hashtagsIds = array();
			$batchArray = array();
			$newTags = array();
			foreach ($hashtags as $data) {
				//валидация хештега
				$tagData = Hashtags::validateHashtag($data->value, $data->id);
				if (strlen($tagData['name']) > 3 && !empty($tagData['id']) && preg_match('/[^0-9]/', $tagData['id']) === 1) {
					$batchArray[] = array('name' => $tagData['name']);
					array_push($newTags, $tagData['name']);
				} else if (strlen($tagData['name']) > 3 && !empty($tagData['id']) && preg_match('/[^0-9]/', $tagData['id']) === 0) {
					array_push($hashtagsIds, $tagData['id']);
				}
			}

			if (!empty($batchArray)) {
				//create tags
				$result = Yii::$app->db->createCommand()->batchInsert(Hashtags::tableName(),
					['name'], $batchArray)->execute();

				if (is_int($result)) {
					$newHashtagsIds = Hashtags::find()->select(['id'])->where(['name' => $newTags])->asArray()->all();
					//получив айди вставляем их в массив всех ID тегов которые нужно добавить к посту
					foreach ($newHashtagsIds as $ids) {
						array_push($hashtagsIds, $ids['id']);
					}
				}
			}

			preg_match_all('/<img[^>]+>/i', $this->description, $descriptionImages);

			foreach ($descriptionImages[0] as $key => $images) {
				$explode = explode('/', $images);
				$transferResult = $this->transferImage(str_replace('">', '', $explode[array_key_last($explode)]));

				if (!empty($transferResult)) {
					$this->description = str_replace($transferResult['oldFilePath'], $transferResult['newFilePath'], $this->description);
				}
			}

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
