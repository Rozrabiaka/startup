<?php

namespace frontend\controllers;

use yii\web\Controller;

class AjaxController extends Controller
{
	public function actionChangeImage()
	{
		if (\Yii::$app->request->isAjax) {
			var_dump($_FILES);
			exit;
		}
	}

	public function actionChangePassword()
	{

	}

	public function actionChangeDescription()
	{

	}

}