<?php

namespace frontend\controllers;

use common\models\History;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class HistoryController extends Controller
{
	const RENDER = '@app/views/site/history/';
	const META = '';

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['logout', 'signup'],
				'rules' => [
					[
						'actions' => ['signup'],
						'allow' => true,
						'roles' => ['?'],
					],
					[
						'actions' => ['logout'],
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
	 * Displays homepage.
	 *
	 * @return mixed
	 */
	public function actionIndex()
	{
		return $this->render(self::RENDER . 'index');
	}

	public function actionAdd()
	{
		$model = new History();

		if($this->request->isPost){
			$model->load($this->request->post());
			//TODO save user
		}

		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => 'Створити історію. ' . self::META
		]);
		return $this->render(self::RENDER . 'add', array(
			'model' => $model
		));
	}
}
