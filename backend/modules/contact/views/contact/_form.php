<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Contact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'readOnly'=>true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'readOnly'=>true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6, 'readOnly'=>true]) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getDropDown()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
