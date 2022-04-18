<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Traitors */

$this->title = 'Update Traitors: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Traitors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="traitors-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_updateForm', [
        'model' => $model,
    ]) ?>

</div>
