<?php

/** @var yii\web\View$this  */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var \frontend\models\ResetPasswordForm $model */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Freedom Home. Відправити лист з підтвердженням.';
?>
<div class="site-resend-verification-email">
    <p>Будь ласка, заповніть свою електронну пошту. Туди буде надіслано електронний лист із підтвердженням.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'resend-verification-email-form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Підтвердити', ['class' => 'blue-b']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
