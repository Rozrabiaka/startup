<?php

/** @var yii\web\View $this */

/* @var $user common\models\User */

use yii\helpers\Html;

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>"/>
		<?php $this->head() ?>

    </head>
    <body>
	<?php $this->beginBody() ?>

    <div class="verify-email">
        <p>Команда Freedom Home вітає вас!</p>
        <p>Дякуємо за реєстрацію на платформі. Будь ласка <?= Html::a('Підтвердідь реєстрацію', $verifyLink) ?>. </p>

        <p>З повагою Freedom Home!</p>
    </div>

	<?php $this->endBody() ?>
    </body>
    </html>

<?php $this->endPage() ?>