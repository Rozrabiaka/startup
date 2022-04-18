<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var \frontend\models\ResetPasswordForm $model */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Freedom Home. Скинути пароль';
?>
<div class="site-reset-password">

    <p>Будь ласка, введіть свій новий пароль:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Зберегти', ['class' => 'blue-b']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
