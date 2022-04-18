<?php

use backend\models\Traitors;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Зрадники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="traitors-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<?= Html::a('Додати', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'name',
			'insult',
			'description:html',
			[
				'attribute' => 'img',
				'format' => 'html',
				'value' => function ($data) {
					return Html::img($data->img, ['width' => '80px']);
				},
			],
			[
				'class' => ActionColumn::className(),
				'urlCreator' => function ($action, Traitors $model, $key, $index, $column) {
					return Url::toRoute([$action, 'id' => $model->id]);
				}
			],
		],
	]); ?>


</div>
