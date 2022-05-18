<?php

namespace frontend\jobs;

use yii\base\BaseObject;

class EmailJob extends BaseObject implements \yii\queue\JobInterface
{
	public $userName;
	public $subjectName;
	public $sendTo;

	public function execute($queue)
	{
		\Yii::$app
			->mailer
			->compose(
				['html' => 'successSignup-html', 'text' => 'successSignup-text'],
				['userName' => $this->userName]
			)
			->setFrom([\Yii::$app->params['supportEmail'] => 'Freedom Home robot'])
			->setTo($this->sendTo)
			->setSubject($this->subjectName . ' ' . \Yii::$app->name)
			->send();
	}
}