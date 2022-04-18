<?php

use backend\models\Contact;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contacts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-index">

    <h1><?= Html::encode($this->title) ?></h1>


	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'id',
			'name',
			'email:email',
			'body:ntext',
			[
				'attribute' => 'status',
				'value' => function ($model) {
					if ($model->status == $model::VIEWED)
						return 'Переглянуто';
					else
						return 'Очікування';
				},
			],
			'datetime',
			[
				'class' => ActionColumn::className(),
				'urlCreator' => function ($action, Contact $model, $key, $index, $column) {
					return Url::toRoute([$action, 'id' => $model->id]);
				}
			],
		],
	]); ?>


</div>
