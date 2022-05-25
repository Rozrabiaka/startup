<?php

use common\widgets\ProfileMenuWidget;
use common\widgets\ProfileTopMenuWidget;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Freedom Home. Налаштування';
?>

<div class="row">
	<?= ProfileTopMenuWidget::widget() ?>
	<?= ProfileMenuWidget::widget() ?>
    <div class="col-lg-8">
        <div class="change-click">
            <div class="change-info-click active">Налаштування профілю</div>
            <div class="change-password-click">Змінити пароль</div>
        </div>
        <div class="create-history profile-right-content">
			<?php $form = ActiveForm::begin(['id' => 'profile-settings-form']); ?>
            <div class="row change-info">
                <div class="col-lg-3">
					<?= $form->field($model, 'image')->widget(FileInput::classname(), [
						'pluginOptions' => [
							'initialPreview' => $model->imagesLinks,
							'browseOnZoneClick' => true,
							'showCaption' => false,
							'showRemove' => false,
							'showCancel' => false,
							'showBrowse' => false,
							'initialPreviewAsData' => true,
							'showUpload' => false,
							'overwriteInitial' => false,
							'allowedFileExtensions' => ['jpg', 'png', 'jpeg'],
							'maxFileSize' => 4800,
						],
						'options' => ['accept' => 'image/*'],
					])->label(false); ?>
                </div>

                <div class="col-lg-9 change-info">
					<?= $form->field($model, 'username')->textInput(['placeholder' => "Логін користувача", 'value' => Yii::$app->user->identity->username])->label("Змінити логін ") ?>

					<?= $form->field($model, 'description')->textArea(['rows' => 10, 'cols' => 10, 'value' => Yii::$app->user->identity->description])->label('Опис'); ?>

                    <div class="form-group">
						<?= Html::submitButton('Оновити', ['class' => 'purple-b purpler-button', 'name' => 'settings-change-info-button']) ?>
                    </div>
                </div>

				<?php ActiveForm::end(); ?>
            </div>

			<?php $form = ActiveForm::begin(['id' => 'profile-settings-form-change-password']); ?>
            <div class="row change-password">
                <div class="col-md-6 offset-md-3">
					<?= $form->field($modelPassword, 'new_password')->passwordInput(['value' => '', 'placeholder' => 'Введіть новий пароль'])->label('Змінити пароль'); ?>
					<?= $form->field($modelPassword, 'password_repeat')->passwordInput(['value' => '', 'placeholder' => 'Повторіть пароль'])->label(false); ?>
                    <div class="form-group">
						<?= Html::submitButton('Оновити', ['class' => 'purple-b purpler-button', 'name' => 'settings-change-password-button']) ?>
                    </div>
                </div>
            </div>
			<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>