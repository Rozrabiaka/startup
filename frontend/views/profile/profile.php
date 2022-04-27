<?php

use common\widgets\ProfileMenuWidget;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use \stkevich\ckeditor5\EditorClassic;

/** @var common\models\History $history */

$this->title = 'Freedom Home. Профіль ' . $model->username;

?>

<div class="profile">
    <div class="row">
        <div class="col-lg-12">
            <div class="header-profile">
                <div class="top-profile">
                    <div class="profile-img">
						<?= Html::img($model->img, ['alt' => $model->username]) ?>
                    </div>
                    <div class="profile-info">
                        <span class="pfi-username"><?= $model->username ?></span>
                        <span class="pfi-email"><?= $model->email ?> </span>
                        <span class="pfi-description pfi-pc"><?= $model->description ?></span>
                    </div>
                    <div class="profile-logout profile-logout-pc">
						<?php
						echo Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
							. Html::submitButton(
								'Вихід',
								['class' => 'purple-b purple-back-none profile-logout-b']
							)
							. Html::endForm()
						?>
                    </div>
                    <div class="profile-logout profile-logout-mobile">
						<?php
						echo Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
							. Html::submitButton(
								Html::img('/images/svg/logout.svg', ['alt' => 'profile logout']),
								['class' => 'purple-b purple-back-none profile-logout-b pf-b-logout']
							)
							. Html::endForm()
						?>
                    </div>
                </div>
                <div class="bottom-profile">
                    <span class="pfi-description">
                        <?= $model->description ?>
                    </span>
                </div>
            </div>
        </div>
		<?= ProfileMenuWidget::widget() ?>
        <div class="col-lg-8">
            <h5 class="mh-block-dark">Створити публікацію</h5>
            <div class="create-history">
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



