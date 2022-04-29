<?php

use common\widgets\ProfileMenuWidget;
use common\widgets\ProfileTopMenuWidget;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Freedom Home. Налаштування';

?>

<div class="row">
	<?= ProfileTopMenuWidget::widget() ?>
    <?= ProfileMenuWidget::widget() ?>
    <div class="col-lg-8">
        <h5 class="mh-block-dark">Налаштування</h5>
        <div class="create-history profile-right-content">
			<?php $form = ActiveForm::begin(['id' => 'profile-settings-form']); ?>

			<?= $form->field($model, 'username')->textInput(['placeholder' => "Титулка"])->label("Змінити логін ") ?>

			<?= $form->field($model, 'description')->textArea(['rows'=> 5,'cols'=>5])->label('Опис'); ?>

			<?= $form->field($model, 'email')->textInput(['readonly'=> true])->label('Пошта'); ?>

			<?= $form->field($model, 'password_hash')->textInput()->label('Пароль'); ?>
            <div class="form-group">
				<?= Html::submitButton('Оновити', ['class' => 'purple-b purpler-button', 'name' => 'create-history-button']) ?>
            </div>

			<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>