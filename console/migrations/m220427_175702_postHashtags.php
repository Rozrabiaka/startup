<?php

use yii\db\Migration;

/**
 * Class m220427_175702_postHashtags
 */
class m220427_175702_postHashtags extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%post_hashtags}}', [
			'id' => $this->primaryKey(),
			'history_id' => $this->integer()->notNull(),
			'hashtag_id' => $this->integer()->notNull(),
		], $tableOptions);

		$this->addForeignKey('fk_post_hashtags_history_id', 'post_hashtags', 'history_id', 'history', 'id');
		$this->addForeignKey('fk_post_hashtag_hashtag_id', 'post_hashtags', 'hashtag_id', 'hashtags', 'id');
	}
}
