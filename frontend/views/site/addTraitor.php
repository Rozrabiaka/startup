<?php

/** @var yii\web\View $this */

/** @var \backend\models\Traitors $model */

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::$app->name . ' додати зрадника';
?>
<div class="add-traitor">
    <h1>Надати інформацію</h1>
	<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
			<?= $form->field($model, 'image')->widget(FileInput::classname(), [
				'language' => 'uk',
				'pluginOptions' => [
					'browseOnZoneClick' => true,
					'showCaption' => false,
					'showRemove' => false,
					'showCancel' => false,
					'showBrowse' => false,
					'initialPreviewAsData' => true,
					'showUpload' => false,
					'overwriteInitial' => false,
					'allowedFileExtensions' => ['jpg', 'png', 'jpeg'],
					'maxFileSize' => 2800,
				],
				'options' => ['accept' => 'image/*'],
			])->label(false); ?>
        </div>

        <div class="col-md-6">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'insult')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'feedback_email')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <div class="form-group">
				<?= Html::submitButton('Додати інформацію', ['class' => 'blue-b cr-tr-b']) ?>
            </div>
        </div>
    </div>

	<?php ActiveForm::end(); ?>
</div>
