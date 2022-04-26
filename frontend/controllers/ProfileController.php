<?php

namespace frontend\controllers;

use common\models\History;
use common\models\User;
use frontend\models\Search;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class ProfileController extends Controller
{
	const META = 'Це найкраща платформа для розповсюдження ваших історій! Багатий функціонал допоможе вам дуже швидко написати подію із вашого життя!';

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['index'],
				'rules' => [
					[
						'actions' => ['index'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				//'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function actionIndex()
	{
		$model = User::find()->where(['id' => Yii::$app->user->id])->one();
		$history = new History();

		if (!empty(Yii::$app->request->post())) {

			echo "<pre>";
			var_dump(Yii::$app->request->post());
			exit;
			$history->load(Yii::$app->request->post());
			$history->user_id = Yii::$app->user->id;

			if ($history->save()) {
				preg_match_all('/<img[^>]+>/i', $history->description, $descriptionImages);

				foreach ($descriptionImages[0] as $key => $images) {
					$explode = explode('/', $images);
					$transferResult = $history->transferImage(str_replace('">', '', $explode[array_key_last($explode)]));

					if (!empty($transferResult)) {
						$history->description = str_replace($transferResult['oldFilePath'], $transferResult['newFilePath'], $history->description);
					}
				}

				Yii::$app->session->setFlash('success', 'Вашу історію було успішно добавлено.');
				return $this->refresh();
			} else {
				Yii::$app->session->setFlash('success', 'Трапилась помилка при додаванні історії. Спробуйте знову.');
			}
		}

		\Yii::$app->getView()->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/profile.js', ['position' => \yii\web\View::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
		\Yii::$app->getView()->registerJsFile(\Yii::$app->request->baseUrl . '/js/hashtags/autocomplete-0.3.0.min.js', ['position' => \yii\web\View::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
		\Yii::$app->getView()->registerJsFile(\Yii::$app->request->baseUrl . '/js/hashtags/jquery-ui.js', ['position' => \yii\web\View::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
		\Yii::$app->getView()->registerJsFile(\Yii::$app->request->baseUrl . '/js/hashtags/hashtags.js', ['position' => \yii\web\View::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
		$this->getView()->registerCssFile("@web/css/profile/profile.css", ['depends' => ['frontend\assets\AppAsset']]);

		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => "Freedom Home. Профіль. " . self::META
		]);

		return $this->render('profile', [
			'model' => $model,
			'history' => $history
		]);
	}
}
