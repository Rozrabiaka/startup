<?php

namespace frontend\controllers;

use common\models\History;
use frontend\models\FrontUser;
use frontend\models\NewPassword;
use frontend\models\ProfileSettingsSearch;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

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
				'only' => ['index', 'settings', 'my-history'],
				'rules' => [
					[
						'actions' => ['index', 'settings', 'my-history'],
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

	/**
	 * Profile index page, save new history.
	 *
	 * @return mixed
	 * @throws \yii\base\InvalidConfigException
	 * @throws \yii\db\Exception
	 */
	public function actionIndex()
	{
		$history = new History();

		if ($history->load(Yii::$app->request->post()) && $history->validate()) {
			if ($history->saveHistory()) {
				Yii::$app->session->setFlash('success', 'Вашу історію було успішно добавлено.');
				return $this->refresh();
			} else {
				Yii::$app->session->setFlash('success', 'Трапилась помилка при додаванні історії. Спробуйте знову.');
			}
		}

		$this->getView()->registerJsFile(\Yii::$app->request->baseUrl . '/js/hashtags/hashtags.js', ['position' => \yii\web\View::POS_END, 'async' => true, 'depends' => [\yii\web\JqueryAsset::className()]]);
		$this->getView()->registerCssFile("@web/css/profile/profile.css", ['depends' => ['frontend\assets\AppAsset']]);

		$this->view->registerMetaTag([
			'name' => 'description',
			'content' => "Freedom Home. Профіль. " . self::META
		]);

		return $this->render('profile', [
			'history' => $history
		]);
	}

	/**
	 * Profile settings page.
	 *
	 * @return mixed
	 * @throws \yii\base\InvalidConfigException
	 * @throws \yii\db\Exception
	 */
	public function actionSettings()
	{
		$model = new FrontUser();
		$modelPassword = new NewPassword();

		if ($model->load(Yii::$app->request->post())) {
			$image = UploadedFile::getInstances($model, 'image');

			if ($model->updateUser($image)) {
				Yii::$app->session->setFlash('success', 'Дані успішно оновлені.');
				return $this->refresh();
			}
		}

		//update passowrd
		if ($modelPassword->load(Yii::$app->request->post()) && $modelPassword->updatePassword()) {
			Yii::$app->session->setFlash('success', 'Пароль було успішно оновлено.');
			return $this->refresh();
		}

		$this->getView()->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/profile.js', ['position' => \yii\web\View::POS_END, 'async' => true, 'depends' => [\yii\web\JqueryAsset::className()]]);
		$this->getView()->registerCssFile("@web/css/profile/profile.css", ['depends' => ['frontend\assets\AppAsset']]);

		$this->view->registerMetaTag([
			'name' => 'description',
			'content' => "Freedom Home. Профіль. Налаштування. " . self::META
		]);

		return $this->render('settings', [
			'model' => $model,
			'modelPassword' => $modelPassword
		]);
	}

	/**
	 * Profile My History page.
	 *
	 * @return mixed
	 * @throws \yii\base\InvalidConfigException
	 */
	public function actionMyHistory()
	{
		$search = new ProfileSettingsSearch();
		$dataProvider = $search->search();

		$this->view->registerMetaTag([
			'name' => 'description',
			'content' => "Freedom Home. Профіль. Мої історії. " . self::META
		]);

		$this->getView()->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/profile.js', ['position' => \yii\web\View::POS_END, 'async' => true, 'depends' => [\yii\web\JqueryAsset::className()]]);
		$this->getView()->registerCssFile("@web/css/profile/profile.css", ['depends' => ['frontend\assets\AppAsset']]);
		$this->getView()->registerCssFile("@web/css/post.css", ['depends' => ['frontend\assets\AppAsset']]);
		\Yii::$app->getView()->registerJsFile(Yii::$app->request->baseUrl . '/js/history.js', ['position' => \yii\web\View::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
		return $this->render('myHistory', [
			'dataProvider' => $dataProvider,
			'search' => $search
		]);
	}
}
