<?php

namespace frontend\controllers;

use backend\models\Traitors;
use frontend\models\Contact;
use frontend\models\Search;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends Controller
{
	const META = 'Ми викриваємо зрадників України, мародерів та інших покидьків. Запрошуємо всіх охочих долучитися до проєкту.PS. Не забувайте про цікаву гру.';

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
		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => "Traitors. " . self::META
		]);
		\Yii::$app->getView()->registerJsFile(Yii::$app->request->baseUrl . '/js/mobile-detect.min.js', ['position' => \yii\web\View::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
		return $this->render('index');
	}

	/**
	 * Displays contact page.
	 *
	 * @return mixed
	 */
	public function actionContact()
	{
		$model = new Contact();
		if ($model->load(Yii::$app->request->post())) {
			if (!empty($model->email)) $model->sendEmail();
			if ($model->save()) Yii::$app->session->setFlash('success', "Дякуємо за звернення. Найближчим часом ми зв'яжимось з вами.");
			else Yii::$app->session->setFlash('error', "Трапилась помилка. Спробуйте ще раз.");
		}

		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => "Traitors. Зв'язатись з нами. " . self::META
		]);

		return $this->render('contact', [
			'model' => $model,
		]);
	}

	public function actionTraitors()
	{
		$query = Traitors::find()->select(["*"]);
		$model = new Search();

		//улучшить поиск
		$q = Yii::$app->getRequest()->getQueryParam('q');

		if (!empty($q)) {
			$explode = explode(' ', $q);
			foreach ($explode as $data) {
				$query->andWhere(['like', 'name', $data]);
			}
		}

		$query->andWhere(['active' => Traitors::ACTIVE]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_DESC
				]
			],
			'pagination' => [
				'pageSize' => 10,
			],
		]);

		foreach ($dataProvider->getModels() as $key => $data) {
			$dataProvider->getModels()[$key]->description = html_entity_decode(strip_tags(mb_strimwidth($data->description, 0, 400, "...")));
		}

		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => 'Traitors. Список зрадників. ' . self::META
		]);

		return $this->render('traitors', [
			'dataProvider' => $dataProvider,
			'model' => $model,
			'q' => $q
		]);
	}

	public function actionAddTraitor()
	{
		$model = new Traitors();

		if ($this->request->isPost && $model->load($this->request->post())) {
			$model->image = UploadedFile::getInstances($model, 'image');
			$imgPath = $model->uploadImages();
			if (!empty($imgPath)) $model->img = $imgPath[0];
			else $model->img = $model->getImageDefaultLink();

			$model->image = null;
			if ($model->save()) {
				if (!empty($model->feedback_email)) $model->sendEmail();
				Yii::$app->session->setFlash('success', "Дякуємо за звернення. Після перевірки інформації виродака буде додано до нашої бази. ");
			} else {
				Yii::$app->session->setFlash('error', "Трапилась помилка. Спробуйте знову.");
			}
		}

		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => 'Traitors. Додати зрадника. ' . self::META
		]);

		return $this->render('addTraitor', [
			'model' => $model
		]);
	}

	public function actionTraitor(int $id)
	{
		$traitor = Traitors::find()->select(["*"])->where(['id' => $id])->andWhere(['active' => Traitors::ACTIVE])->one();
		if (empty($traitor)) return $this->redirect(['error']);

		$traitorsMore = Traitors::find()->where(['!=', 'id', $id])->orderBy('RAND()')->limit(3)->asArray()->all();
		foreach ($traitorsMore as $key => $data) {
			$traitorsMore[$key]['description'] = html_entity_decode(strip_tags(mb_strimwidth($data['description'], 0, 100, "...")));
		}

		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => 'Traitors. ' . html_entity_decode(strip_tags($traitor->description)) . '. ' . self::META
		]);

		return $this->render('traitor', array(
			'traitor' => $traitor,
			'traitorsMore' => $traitorsMore
		));
	}

//	/**
//	 * Logs in a user.
//	 *
//	 * @return mixed
//	 */
//	public function actionLogin()
//	{
//		if (!Yii::$app->user->isGuest) {
//			return $this->goHome();
//		}
//
//		$model = new LoginForm();
//		if ($model->load(Yii::$app->request->post()) && $model->login()) {
//			return $this->goBack();
//		}
//
//		$model->password = '';
//
//		return $this->render('login', [
//			'model' => $model,
//		]);
//	}
//
//	/**
//	 * Logs out the current user.
//	 *
//	 * @return mixed
//	 */
//	public function actionLogout()
//	{
//		Yii::$app->user->logout();
//
//		return $this->goHome();
//	}
//
//	/**
//	 * Signs user up.
//	 *
//	 * @return mixed
//	 */
//	public function actionSignup()
//	{
//		$model = new SignupForm();
//		if ($model->load(Yii::$app->request->post()) && $model->signup()) {
//			Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
//			return $this->goHome();
//		}
//
//		return $this->render('signup', [
//			'model' => $model,
//		]);
//	}
//
//	/**
//	 * Requests password reset.
//	 *
//	 * @return mixed
//	 */
//	public function actionRequestPasswordReset()
//	{
//		$model = new PasswordResetRequestForm();
//		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//			if ($model->sendEmail()) {
//				Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
//
//				return $this->goHome();
//			}
//
//			Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
//		}
//
//		return $this->render('requestPasswordResetToken', [
//			'model' => $model,
//		]);
//	}
//
//	/**
//	 * Resets password.
//	 *
//	 * @param string $token
//	 * @return mixed
//	 * @throws BadRequestHttpException
//	 */
//	public function actionResetPassword($token)
//	{
//		try {
//			$model = new ResetPasswordForm($token);
//		} catch (InvalidArgumentException $e) {
//			throw new BadRequestHttpException($e->getMessage());
//		}
//
//		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
//			Yii::$app->session->setFlash('success', 'New password saved.');
//
//			return $this->goHome();
//		}
//
//		return $this->render('resetPassword', [
//			'model' => $model,
//		]);
//	}
//
//	/**
//	 * Verify email address
//	 *
//	 * @param string $token
//	 * @return yii\web\Response
//	 * @throws BadRequestHttpException
//	 */
//	public function actionVerifyEmail($token)
//	{
//		try {
//			$model = new VerifyEmailForm($token);
//		} catch (InvalidArgumentException $e) {
//			throw new BadRequestHttpException($e->getMessage());
//		}
//		if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
//			Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
//			return $this->goHome();
//		}
//
//		Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
//		return $this->goHome();
//	}
//
//	/**
//	 * Resend verification email
//	 *
//	 * @return mixed
//	 */
//	public function actionResendVerificationEmail()
//	{
//		$model = new ResendVerificationEmailForm();
//		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//			if ($model->sendEmail()) {
//				Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
//				return $this->goHome();
//			}
//			Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
//		}
//
//		return $this->render('resendVerificationEmail', [
//			'model' => $model
//		]);
//	}
}
