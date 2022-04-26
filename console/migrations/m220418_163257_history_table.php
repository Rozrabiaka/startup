<?php

use yii\db\Migration;

/**
 * Class m220418_163257_history_table
 */
class m220418_163257_history_table extends Migration
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

		$this->createTable('{{%history}}', [
			'id' => $this->primaryKey(),
			'title' => $this->string(255)->notNull(),
			'description' => $this->text()->notNull(),
			'user_id' => $this->integer()->notNull(),
			'date' => $this->timestamp()->defaultValue('CURRENT_TIMESTAMP')
		], $tableOptions);

		$this->addForeignKey('fk_history_user_id', 'history', 'user_id', 'user', 'id');
    }
}
