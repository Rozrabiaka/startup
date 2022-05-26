<?php

use yii\db\Migration;

/**
 * Class m220519_205512_create_rbac_data
 */
class m220519_205512_create_rbac_data extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$auth = Yii::$app->authManager;

		$blockUserHistory = $auth->createPermission('blockHistory');
		$auth->add($blockUserHistory);

		$blockUser = $auth->createPermission('blockUser');
		$auth->add($blockUser);

		// role moderator
		$moderatorRole = $auth->createRole('moderator');
		$auth->add($moderatorRole);

		$adminRole = $auth->createRole('admin');
		$auth->add($adminRole);

		$auth->addChild($moderatorRole, $blockUser);
		$auth->addChild($moderatorRole, $blockUserHistory);

		$auth->addChild($adminRole, $moderatorRole);

		$auth->assign($adminRole, 5);
	}
}
