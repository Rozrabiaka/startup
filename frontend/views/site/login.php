<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */

/** @var \common\models\LoginForm $model */

use common\widgets\FooterMenuWidget;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Freedom Home. Вхід в систему';
?>
<div class="row">
    <div class="col-lg-4">
		<?= FooterMenuWidget::widget() ?>
    </div>
    <div class="col-lg-8">
        <div class="form">
            <div class="mh-block-dark form-text-header">
                <h1>Авторизація</h1>
            </div>
            <div class="background-form">
                <div class="col-lg-6 offset-lg-3 col-md-6 offset-md-3">
					<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

					<?= $form->field($model, 'username')->textInput(['placeholder' => "Ім'я користувача"])->label(false) ?>

					<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль'])->label(false) ?>

					<?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group">
						<?= Html::submitButton('Авторизація', ['class' => 'purple-b purpler-button', 'name' => 'login-button']) ?>
                    </div>

                    <div class="form-links">
						<?= Html::a('Забули пароль?', ['site/request-password-reset']) ?>
                    </div>

                    <div class="buttons-auth button button-auth-google">
                        <p>Увійти за допомогою Google</p>
						<?= Html::a(Html::img('/images/svg/google.svg', ['alt' => 'Google login']), ['/site/auth?authclient=google'], ['class' => '']) ?>

                    </div>

					<?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

