<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Quote */

$this->title = 'Traitors UA - Додати Цитату';
$this->params['breadcrumbs'][] = ['label' => 'Quotes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quote-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
