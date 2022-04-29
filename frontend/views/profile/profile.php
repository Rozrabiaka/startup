<?php

use common\widgets\ProfileMenuWidget;
use common\widgets\ProfileTopMenuWidget;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use \stkevich\ckeditor5\EditorClassic;

/** @var common\models\History $history */

$this->title = 'Freedom Home. Профіль';

?>

<div class="profile">
    <div class="row">
		<?= ProfileTopMenuWidget::widget() ?>
		<?= ProfileMenuWidget::widget() ?>
        <div class="col-lg-8">
            <h5 class="mh-block-dark">Створити публікацію</h5>
            <div class="create-history profile-right-content">
				<?php $form = ActiveForm::begin(['id' => 'create-history-form']); ?>

				<?= $form->field($history, 'title')->textInput(['placeholder' => "Титулка"])->label(false) ?>

				<?= $form->field($history, 'description')->widget(EditorClassic::className(),
					[
						'toolbar' => ['imageUpload', 'bold', 'link', 'bulletedList', 'uploadImage', 'blockQuote'],
						'uploadUrl' => 'uploadImage.php',
					]
				)->label(false); ?>

                <div class="input_hashtags form-control">
					<?= $form->field($history, 'hashtags')->textInput(['class' => 'hashtags'])->label(false) ?>
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



