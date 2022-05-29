<?php

use common\widgets\FooterMenuWidget;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = Yii::$app->name . '. Створити спільноту';
?>

<div class="create-community">
    <div class="row">
        <div class="col-lg-4">
			<?= FooterMenuWidget::widget() ?>
        </div>
        <div class="col-lg-8">
            <div class="new-community">
                <h5 class="mh-block-dark">Створити спільноту</h5>
                <div class="menu-back info-block new-community-info-block">
                    <div class="col-md-8 offset-md-2">
						<?php $form = ActiveForm::begin(['id' => 'create-community-form']); ?>
                        <div class="community-step1">
							<?= $form->field($model, 'name')->textInput(['placeholder' => "Введіть назву спільноти"])->label(false) ?>

							<?= $form->field($model, 'description')->textarea(['placeholder' => "Введіть опис спільноти", 'row' => 6, 'cols' => 6])->label(false); ?>
                        </div>
                        <div class="community-step2">
							<?= $form->field($model, 'image')->widget(FileInput::classname(), [
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
									'maxFileSize' => 4800,
									'dropZoneTitle' => 'Завантажте фото спільноти <br>Не більше 4 мб',
									'dropZoneClickTitle' => ''
								],
								'options' => ['accept' => 'image/*'],
							])->label(false); ?>
                        </div>
                        <div class="community-step3">
                            <p>Виберіть налаштування спільноти</p>
							<?= $form->field($model, 'community_access')->radioList($model->getRadioArrayCommunityAccess())->label(false); ?>
							<?= $form->field($model, 'community_his_add')->radioList($model->getRadioArrayCommunityHistoryAdd())->label(false); ?>
                        </div>
						<?php ActiveForm::end(); ?>

                        <div class="form-group">
							<?= Html::button('Далі', ['class' => 'purple-b purpler-button community-b']) ?>
                        </div>
                    </div>
                    <div class="community-step">
                        <span class="community-step-count"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
