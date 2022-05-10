<?php

namespace common\models;

/**
 * This is the model class for table "post_hashtags".
 *
 * @property int $id
 * @property int $history_id
 * @property int $hashtag_id
 *
 * @property Hashtags $hashtag
 * @property History $history
 */
class HistoryHashtags extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'history_hashtags';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['history_id', 'hashtag_id'], 'required'],
			[['history_id', 'hashtag_id'], 'integer'],
			[['hashtag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hashtags::className(), 'targetAttribute' => ['hashtag_id' => 'id']],
			[['history_id'], 'exist', 'skipOnError' => true, 'targetClass' => History::className(), 'targetAttribute' => ['history_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'history_id' => 'History ID',
			'hashtag_id' => 'Hashtag ID',
		];
	}

	/**
	 * Gets query for [[Hashtag]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getHashtag()
	{
		return $this->hasOne(Hashtags::className(), ['id' => 'hashtag_id'])->select(['id', 'name']);
	}

	/**
	 * Gets query for [[History]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getHistory()
	{
		return $this->hasOne(History::className(), ['id' => 'history_id']);
	}
}
