<?php

namespace backend\controllers;

use backend\models\Traitors;
use yii\web\Controller;
use Yii;

class AjaxController extends Controller
{
	public function actionDeleteTraitorsImage()
	{

		if (Yii::$app->request->isAjax) {
			$data = Yii::$app->request->post();
			$id = $data['key'];

			$model = new Traitors();
			$result = $model::find()->where(['id' => $id])->one();

			if (file_exists(Yii::getAlias('@frontend') . '/web' . $result->img) and $result->img !== $model->getImageDefaultLink()) {
				unlink(Yii::getAlias('@frontend') . '/web' . $result->img);
			}

			return true;
		}

		return false;
	}
}