<?php
use common\widgets\ProfileMenuWidget;
use common\widgets\ProfileTopMenuWidget;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Freedom Home. Редагувати історію. ';
?>

<div class="edit-post">
	<div class="row">
		<?= ProfileTopMenuWidget::widget() ?>
		<?= ProfileMenuWidget::widget() ?>
		<div class="col-lg-8">
			<h5 class="mh-block-dark">Редагування посту</h5>
			<div class="create-history profile-right-content">
				<?php $form = ActiveForm::begin(['id' => 'edit-history-form']); ?>

				<?= $form->field($model, 'title')->textInput(['placeholder' => "Титулка"])->label(false) ?>

				<?= $form->field($model, 'description')->textarea()->label(false); ?>

				<div class="input_hashtags form-control">
					<?= $form->field($model, 'hashtags')->textInput(['class' => 'hashtags', 'placeholder' => "Додати хештеги..."])->label(false) ?>
				</div>
				<div id="autocomplete-container"></div>
				<div class="form-group">
					<?= Html::submitButton('Опубліковати', ['class' => 'purple-b purpler-button', 'name' => 'create-history-button']) ?>
				</div>

				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>
