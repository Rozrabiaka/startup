<?php
$this->title = 'Traitors UA';

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>


<div class="add-history">
	<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
			<?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Титулка'])->label(false) ?>

			<?= $form->field($model, 'description')->textarea(['rows' => 6, 'placeholder' => 'Введіть текст'])->label(false) ?>

            <div class="form-group">
				<?= Html::submitButton('Створити', ['class' => 'blue-b cr-tr-b']) ?>
            </div>
        </div>
    </div>
	<?php ActiveForm::end(); ?>
</div>