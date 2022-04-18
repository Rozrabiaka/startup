<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
Вітаємо <?= $user->username ?>,

Перейдіть за посиланням нижче, щоб скинути пароль:

<?= $resetLink ?>
