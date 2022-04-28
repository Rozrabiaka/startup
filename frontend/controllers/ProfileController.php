<?php

namespace frontend\controllers;

use common\models\Hashtags;
use common\models\History;
use common\models\HistoryHashtags;
use common\models\User;
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
				'only' => ['index', 'settings'],
				'rules' => [
					[
						'actions' => ['index', 'settings'],
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
		$history = new History();

		if (!empty(Yii::$app->request->post())) {
			$postData = Yii::$app->request->post('History');

			if (!empty($postData['hashtags']) AND $hashtags = json_decode($postData['hashtags'])) {

				//делаем одномерный массив для поиска одним запросом
				$searchArray = array();
				foreach ($hashtags as $data) {
					array_push($searchArray, $data->value);
				}

				//ищем хештеги поимени
				$hashtagsModel = new Hashtags();
				$issetHashtags = $hashtagsModel::find()->select(['id', 'name'])->where(['name' => $searchArray])->asArray()->all();

				//Создаем 2 массива, один который хранит имена хештегов, 2рой будет хранить ID тегов для записи в БД postHashtags
				$hashtagsNames = array(); //to one-dimensional array
				$hashtagsIds = array(); //array with existing tags
				foreach ($issetHashtags as $isset) {
					array_push($hashtagsNames, $isset['name']);
					array_push($hashtagsIds, $isset['id']); //tag to added (existing tags)
				}

				//теги которые нужно создать, в batchArray сохраняем для insert, $newTags для поиска в БД чтобы получить ID тегов
				$batchArray = array();
				$newTags = array();
				foreach ($searchArray as $tag) {
					if (!in_array($tag, $hashtagsNames)) {
						$batchArray[] = array(
							'name' => $tag
						);
						array_push($newTags, $tag);
					}
				}

				//create tags
				$result = Yii::$app->db->createCommand()->batchInsert($hashtagsModel::tableName(),
					['name'], $batchArray)->execute();

				if (is_int($result)) {
					$newHashtagsIds = $hashtagsModel::find()->select(['id'])->where(['name' => $newTags])->asArray()->all();

					//получив айди вставляем их в массив всех ID тегов которые нужно добавить к посту
					foreach ($newHashtagsIds as $ids) {
						array_push($hashtagsIds, $ids['id']);
					}
				}
			}

			//Сохраняем пост
			$history->load(Yii::$app->request->post());

			preg_match_all('/<img[^>]+>/i', $history->description, $descriptionImages);

			foreach ($descriptionImages[0] as $key => $images) {
				$explode = explode('/', $images);
				$transferResult = $history->transferImage(str_replace('">', '', $explode[array_key_last($explode)]));

				if (!empty($transferResult)) {
					$history->description = str_replace($transferResult['oldFilePath'], $transferResult['newFilePath'], $history->description);
				}
			}

			$history->user_id = Yii::$app->user->id;

			if ($history->save()) {
				//сохраняем в таблицу postHashtags массив с тегами $hashtagsIds
				if (!empty($hashtagsIds)) {
					$historyBatchArray = array();
					foreach ($hashtagsIds as $id) {
						$historyBatchArray[] = array(
							'history_id' => $history->id,
							'hashtag_id' => $id
						);
					}

					Yii::$app->db->createCommand()->batchInsert(HistoryHashtags::tableName(),
						['history_id', 'hashtag_id'], $historyBatchArray)->execute();
				}

				Yii::$app->session->setFlash('success', 'Вашу історію було успішно добавлено.');
				return $this->refresh();
			} else {
				Yii::$app->session->setFlash('success', 'Трапилась помилка при додаванні історії. Спробуйте знову.');
			}
		}

		\Yii::$app->getView()->registerJsFile(\Yii::$app->request->baseUrl . '/js/hashtags/autocomplete-0.3.0.min.js', ['position' => \yii\web\View::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
		\Yii::$app->getView()->registerJsFile(\Yii::$app->request->baseUrl . '/js/hashtags/jquery-ui.js', ['position' => \yii\web\View::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
		\Yii::$app->getView()->registerJsFile(\Yii::$app->request->baseUrl . '/js/hashtags/hashtags.js', ['position' => \yii\web\View::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
		$this->getView()->registerCssFile("@web/css/profile/profile.css", ['depends' => ['frontend\assets\AppAsset']]);

		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => "Freedom Home. Профіль. " . self::META
		]);

		return $this->render('profile', [
			'history' => $history
		]);
	}

	public function actionSettings()
	{
		$this->getView()->registerCssFile("@web/css/profile/profile.css", ['depends' => ['frontend\assets\AppAsset']]);
		return $this->render('settings');
	}
}