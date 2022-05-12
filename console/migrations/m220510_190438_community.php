<?php

use yii\db\Migration;

/**
 * Class m220510_190438_community
 */
class m220510_190438_community extends Migration
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

		$this->createTable('{{%community}}', [
			'id' => $this->primaryKey(),
			'name' => $this->string(255)->notNull(),
			'img' => $this->string(255)->notNull(),
			'date' => $this->timestamp()->notNull(),
		], $tableOptions);
	}
}
