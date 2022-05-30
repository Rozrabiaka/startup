<?php

use common\widgets\ProfileMenuWidget;
use common\widgets\ProfileTopMenuWidget;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::$app->name . '. Редагувати спільноут';
?>

<div class="row">
	<?= ProfileTopMenuWidget::widget() ?>
	<?= ProfileMenuWidget::widget() ?>
    <div class="col-lg-8">
        <h5 class="mh-block-dark"><?= $model->name ?></h5>
        <div class="edit-community">
			<?php $form = ActiveForm::begin(['id' => 'edit-community-form']); ?>
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
						'options' => ['accept' => 'image/*', 'class' => 'input-img-c'],
					])->label(false); ?>
                </div>

                <div class="col-lg-9 change-info">
					<?= $form->field($model, 'name')->textInput(['placeholder' => "Опис спільноти"])->label() ?>

					<?= $form->field($model, 'description')->textArea(['rows' => 10, 'cols' => 10])->label('Опис'); ?>

                    <?= $form->field($model, 'community_access')->radioList($model->getRadioArrayCommunityAccess())->label(false); ?>

                    <?= $form->field($model, 'community_his_add')->radioList($model->getRadioArrayCommunityHistoryAdd())->label(false); ?>

                    <div class="form-group">
						<?= Html::submitButton('Оновити', ['class' => 'purple-b purpler-button', 'name' => 'settings-change-info-button']) ?>
                    </div>
                </div>
            </div>
			<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>