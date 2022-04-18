<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Traitors */

$this->title = 'Додати зрадника';
$this->params['breadcrumbs'][] = ['label' => 'Traitors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="traitors-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
