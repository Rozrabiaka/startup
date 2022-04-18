<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Freedom Home. Вхід в систему';
?>
<div class="site-login">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:1em 0">
                    Якщо ви забули свій пароль, ви можете його <?= Html::a('скинути', ['site/request-password-reset']) ?>.
                    <br>
                    Потрібен новий електронний лист для підтвердження? <?= Html::a('Надіслати повторно', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Вхід', ['class' => 'blue-b', 'name' => 'login-button']) ?>
					<?= Html::a('Реєстрація', ['/signup'], ['class' => 'blue-b register']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
