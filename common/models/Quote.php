<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quote".
 *
 * @property int $id
 * @property string $text
 * @property string $author
 */
class Quote extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quote';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'author'], 'required'],
            [['text'], 'string'],
            [['author'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Текст',
            'author' => 'Автор цитати',
        ];
    }
}
