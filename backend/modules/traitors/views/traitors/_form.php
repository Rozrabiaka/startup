<?php

use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Traitors */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="traitors-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'insult')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'description')->widget(CKEditor::className(), [
		'options' => ['rows' => 6],
		'preset' => 'custom',
		'clientOptions' => [
			'toolbar' => false,
			'removePlugins' => 'image'
		],
	]) ?>

	<?= $form->field($model, 'image[]')->widget(FileInput::classname(), [
		'showMessage' => true,
		'pluginOptions' => [
			'showUpload' => false,
			'overwriteInitial' => true,
			'allowedFileExtensions' => ['jpg', 'png', 'jpeg'],
			'maxFileSize' => 2800
		],
		'options' => ['multiple' => false, 'accept' => 'image/*'],
	]); ?>

    <div class="form-group">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

	<?php ActiveForm::end(); ?>

</div>
