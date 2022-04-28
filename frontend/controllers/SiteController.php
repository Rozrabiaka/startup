<?php

namespace frontend\controllers;

use common\models\Auth;
use common\models\History;
use common\models\LoginForm;
use common\models\User;
use frontend\models\Contact;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
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
				'only' => ['logout', 'signup', 'profile'],
				'rules' => [
					[
						'actions' => ['signup'],
						'allow' => true,
						'roles' => ['?'],
					],
					[
						'actions' => ['logout', 'profile'],
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
			'auth' => [
				'class' => 'yii\authclient\AuthAction',
				'successCallback' => [$this, 'onAuthSuccess'],
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
			'content' => "Freedom Home. " . self::META
		]);

		$model = new History();
		$dataProvider = $model->historis();

		\Yii::$app->getView()->registerJsFile(Yii::$app->request->baseUrl . '/js/mobile-detect.min.js', ['position' => \yii\web\View::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
		$this->getView()->registerCssFile("@web/css/index.css", ['depends' => ['frontend\assets\AppAsset']]);
		$this->getView()->registerCssFile("@web/css/post.css", ['depends' => ['frontend\assets\AppAsset']]);

		return $this->render('index', array(
			'dataProvider' => $dataProvider
		));
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
			'content' => "Freedom Home. Зв'язатись з нами. " . self::META
		]);

		return $this->render('contact', [
			'model' => $model,
		]);
	}

	/**
	 * Logs in a user.
	 *
	 * @return mixed
	 */
	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		}

		$model->password = '';

		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => 'Freedom Home. Вхід в систему. ' . self::META
		]);

		return $this->render('login', [
			'model' => $model,
		]);
	}

	/**
	 * Logs out the current user.
	 *
	 * @return mixed
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}

	/**
	 * @param $client
	 * @return string|\yii\web\Response
	 * @throws \yii\base\Exception
	 * @throws \yii\db\Exception
	 */

	public function onAuthSuccess($client)
	{
		$attributes = $client->getUserAttributes();

		/* @var $auth Auth */
		$auth = Auth::find()->where([
			'source' => $client->getId(),
			'source_id' => $attributes['id'],
		])->one();

		if (Yii::$app->user->isGuest) {
			if ($auth) { // авторизация
				$user = $auth->user;
				Yii::$app->user->login($user);
			} else { // регистрация
				$password = Yii::$app->security->generateRandomString(25);
				$user = new User([
					'username' => User::generateRandomUserName(),
					'email' => $attributes['email'],
					'password' => $password,
					'which_user' => 0,
					'status' => 10,
					'img' => '/images/no-image.png'
				]);

				$user->generateAuthKey();
				$user->generatePasswordResetToken();
				$transaction = $user->getDb()->beginTransaction();
				if ($user->save()) {
					$auth = new Auth([
						'user_id' => $user->id,
						'source' => $client->getId(),
						'source_id' => (string)$attributes['id'],
					]);
					if ($auth->save()) {
						$transaction->commit();
						Yii::$app->user->login($user);
						return $this->redirect('/site/index/');
					} else {
						return $this->render('error');
					}
				} else {
					return $this->render('error');
				}
			}
		} else { // Пользователь уже зарегистрирован
			if (!$auth) { // добавляем внешний сервис аутентификации
				$auth = new Auth([
					'user_id' => Yii::$app->user->id,
					'source' => $client->getId(),
					'source_id' => $attributes['id'],
				]);
				$auth->save();
			}
		}
	}

	/**
	 * Signs user up.
	 *
	 * @return mixed
	 */
	public function actionSignup()
	{
		$model = new SignupForm();
		if ($model->load(Yii::$app->request->post()) && $model->signup()) {
			Yii::$app->session->setFlash('success', 'Дякуємо за реєстрацію. Будь ласка, перевірте свою електронну пошту для підтвердження.');
			return $this->goHome();
		}

		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => 'Freedom Home. Реєстрація. ' . self::META
		]);

		return $this->render('signup', [
			'model' => $model,
		]);
	}

	/**
	 * Requests password reset.
	 *
	 * @return mixed
	 */
	public function actionRequestPasswordReset()
	{
		$model = new PasswordResetRequestForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->sendEmail()) {
				Yii::$app->session->setFlash('success', 'Перевірте свою електронну пошту, щоб отримати подальші інструкції.');

				return $this->goHome();
			}

			Yii::$app->session->setFlash('error', 'На жаль, ми не можемо скинути пароль для вказаної адреси електронної пошти.');
		}

		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => 'Freedom Home. Cкидання пароля.'
		]);

		return $this->render('requestPasswordResetToken', [
			'model' => $model,
		]);
	}

	/**
	 * Resets password.
	 *
	 * @param string $token
	 * @return mixed
	 * @throws BadRequestHttpException
	 */
	public function actionResetPassword($token)
	{
		try {
			$model = new ResetPasswordForm($token);
		} catch (\InvalidArgumentException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}

		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
			Yii::$app->session->setFlash('success', 'Новий пароль збережено.');

			return $this->goHome();
		}

		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => 'Freedom Home. Cкидання пароля.'
		]);

		return $this->render('resetPassword', [
			'model' => $model,
		]);
	}

	/**
	 * Verify email address
	 *
	 * @param string $token
	 * @return yii\web\Response
	 * @throws BadRequestHttpException
	 */
	public function actionVerifyEmail($token)
	{
		try {
			$model = new VerifyEmailForm($token);
		} catch (\InvalidArgumentException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}
		if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
			Yii::$app->session->setFlash('success', 'Вашу електронну пошту підтверджено.');
			return $this->goHome();
		}

		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => 'Freedom Home. Перевірте електронну пошту.'
		]);

		Yii::$app->session->setFlash('error', 'На жаль, ми не можемо підтвердити ваш обліковий запис за допомогою наданого токена.');
		return $this->goHome();
	}

	/**
	 * Resend verification email
	 *
	 * @return mixed
	 */
	public function actionResendVerificationEmail()
	{
		$model = new ResendVerificationEmailForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->sendEmail()) {
				Yii::$app->session->setFlash('success', 'Перевірте свою електронну пошту, щоб отримати подальші інструкції.');
				return $this->goHome();
			}
			Yii::$app->session->setFlash('error', 'На жаль, ми не можемо повторно надіслати електронний лист для підтвердження наданої електронної адреси.');
		}

		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => 'Freedom Home. Відправити лист з підтвердженням.'
		]);

		return $this->render('resendVerificationEmail', [
			'model' => $model
		]);
	}
}