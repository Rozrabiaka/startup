<?php

use yii\db\Migration;

/**
 * Class m220425_170921_hashtags
 */
class m220425_170921_hashtags extends Migration
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

		$this->createTable('{{%hashtags}}', [
			'id' => $this->primaryKey(),
			'name' => $this->string(255)->unique()->notNull(),
			'date' => $this->timestamp()->defaultValue('CURRENT_TIMESTAMP')
		], $tableOptions);
	}
}
