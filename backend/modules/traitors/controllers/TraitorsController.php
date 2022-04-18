<?php

namespace backend\modules\traitors\controllers;

use backend\models\Traitors;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * TraitorsController implements the CRUD actions for Traitors model.
 */
class TraitorsController extends Controller
{
	/**
	 * @inheritDoc
	 */
	public function behaviors()
	{
		return array_merge(
			parent::behaviors(),
			[
				'access' => [
					'class' => AccessControl::className(),
					'rules' => [
						[
							'actions' => ['view', 'index', 'create', 'update', 'delete'],
							'allow' => true,
							'roles' => ['@'],
						],
					],
				],
				'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [
						'delete' => ['POST'],
					],
				],
			]
		);
	}

	/**
	 * Lists all Traitors models.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Traitors::find(),

			'pagination' => [
				'pageSize' => 10
			],
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_DESC,
				]
			],
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Traitors model.
	 * @param int $id ID
	 * @return string
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Traitors model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return string|\yii\web\Response
	 */
	public function actionCreate()
	{
		$model = new Traitors();

		if ($this->request->isPost) {
			if ($model->load($this->request->post())) {
				$model->image = UploadedFile::getInstances($model, 'image');
				$imgPath = $model->uploadImages();

				if (!empty($imgPath)) {
					$model->active = $model::ACTIVE;
					$model->img = $imgPath[0];
					if ($model->save()) {
						Yii::$app->session->setFlash('success', "Виродка було успішно додано.");
						return $this->redirect(['view', 'id' => $model->id]);
					} else {
						Yii::$app->session->setFlash('error', "Трапилась помилка при додаванні виродка. Спробуйте знову.");
					}
				}
			}
		} else {
			$model->loadDefaultValues();
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing Traitors model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param int $id ID
	 * @return string|\yii\web\Response
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($this->request->isPost && $model->load($this->request->post())) {
			$model->image = UploadedFile::getInstances($model, 'image');
			$imgPath = $model->uploadImages();

			if (file_exists(Yii::getAlias('@frontend') . '/web' . $model->img) and !empty($model->img_path) and !empty($imgPath)) {
				unlink(Yii::getAlias('@frontend') . '/web' . $model->img);
			}

			if (!empty($imgPath)) $model->img = $imgPath[0];
			if ($model->save()) {
				Yii::$app->session->setFlash('success', "Виродка було успішно оновлено.");
				return $this->redirect(['view', 'id' => $model->id]);
			} else {
				Yii::$app->session->setFlash('error', "Трапилась помилка при оновлені виродка. Спробуйте знову.");
			}
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Traitors model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param int $id ID
	 * @return \yii\web\Response
	 * @throws NotFoundHttpException if the model cannot be found
	 * @throws \yii\db\StaleObjectException
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);

		if (file_exists(Yii::getAlias('@frontend') . '/web' . $model->img) and !empty($model->img) and $model->img !== $model->getImageDefaultLink()) {
			unlink(Yii::getAlias('@frontend') . '/web' . $model->img);
		}

		$model->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Traitors model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id ID
	 * @return Traitors the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Traitors::findOne(['id' => $id])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
