<?php

namespace common\widgets;

use common\models\User;
use Yii;
use yii\base\Widget;

class ProfileTopMenuWidget extends Widget
{
	public $userId = null;

	public function run()
	{
		if(!empty($this->userId)){
			$userData = User::find()->select(['id', 'username', 'description', 'img', 'email'])->where(['id' => $this->userId])->one();
			$description = mb_strimwidth($userData->description, 0, 130, '...');
		}else{
			$userData = Yii::$app->user->identity;
			$description = mb_strimwidth(Yii::$app->user->identity->description, 0, 130, '...');
		}

		return $this->render('profileTopMenu', [
			'userData' => $userData,
			'description' => $description
		]);
	}
}