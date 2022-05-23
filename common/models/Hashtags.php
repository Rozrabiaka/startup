<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hashtags".
 *
 * @property int $id
 * @property string $name
 * @property string|null $date
 */
class Hashtags extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'hashtags';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['date'], 'safe'],
			[['status'], 'integer'],
			[['name'], 'string', 'max' => 255],
			[['name'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Тег',
			'date' => 'Дата',
			'status' => 'Статус'
		];
	}

	public static function validateHashtag($tag, $id)
	{
		//validate tag
		$tag = preg_replace("/[^a-zа-щА-ЩЬьЮюЯяЇїІіЄєҐґA-ZА-Яа-я0-9\s+]/u", '', $tag);
		if (preg_match('/[^0-9]/', $tag) === 0) $tag = null;
		$tag = mb_strtoupper(mb_substr(strtolower($tag), 0, 1)) . mb_substr(strtolower($tag), 1);

		//validate tag id
		$explodeId = explode('-', $id);

		$g = $explodeId[0];
		$afterG = $explodeId[1];

		if ($g !== 'g' || empty($afterG)) $id = null;
		else if (strlen($afterG) !== 4 && preg_match('/[^0-9]/', $afterG) === 1) $id = null;
		else if (strlen($afterG) > 4 && preg_match('/[^0-9]/', $afterG) !== 0) $id = null;
		else $id = $afterG;

		return array(
			'name' => $tag,
			'id' => $id
		);
	}
}
