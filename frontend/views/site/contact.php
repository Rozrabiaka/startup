<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */

/** @var \frontend\models\Contact $model */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::$app->name . " зв'язатись з нами";
?>
<div class="site-contact">
    <h1>Зв'язатись з нами</h1>
    <p>
        Якщо ви бажаєте приєднатись до проєкту, будь ласка, заповніть форму. Ми обов'язково вам відпишемо!
    </p>

    <div class="row">
        <div class="col-lg-5">
			<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

			<?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

			<?= $form->field($model, 'email') ?>

			<?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

			<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
				'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
			]) ?>

            <div class="form-group">
				<?= Html::submitButton('Підтвердити', ['class' => 'blue-b', 'name' => 'contact-button']) ?>
            </div>

			<?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
