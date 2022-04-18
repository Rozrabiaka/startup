<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var \frontend\models\PasswordResetRequestForm $model */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Freedom Home. Запит на скидання пароля';
?>
<div class="site-request-password-reset">
    <p>Будь ласка, заповніть свою електронну пошту. Туди буде надіслано посилання для відновлення пароля.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Підтвердити', ['class' => 'blue-b']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
