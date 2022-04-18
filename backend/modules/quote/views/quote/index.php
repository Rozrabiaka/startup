<?php

use common\models\Quote;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Traitors UA - Цитати';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quote-index">

    <h1>Цитати</h1>

    <p><?= Html::a('Додати цитату', ['create'], ['class' => 'btn btn-success']) ?></p>


	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'text:ntext',
			'author',
			[
				'class' => ActionColumn::className(),
				'urlCreator' => function ($action, Quote $model) {
					return Url::toRoute([$action, 'id' => $model->id]);
				}
			],
		],
	]); ?>


</div>
