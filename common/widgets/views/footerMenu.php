<?php

use yii\bootstrap4\Html;

?>

<div class="menu-contact border-menu footer-menu mobile-none">
    <h5 class="mh-block-dark">Зв'язатись з нами</h5>
    <div class="social-links menu-back">
        <ul>
            <li><?= Html::a(Html::img('/images/svg/telegram.svg', ['alt' => 'telegram', 'class' => '']) . 'Freedom Home в Telegram', 'https://t.me/+5gFPWLJC9zpiZGU0', ['class' => 'mc-social-links', 'target' => '_blank']) ?></li>
            <li><?= Html::a(Html::img('/images/svg/mail.svg', ['alt' => 'telegram', 'class' => '']) . 'Наша електронна пошта', ['/signup'], ['class' => 'mc-social-links']) ?></li>
        </ul>
    </div>
    <div class="mh-block-dark" style="padding-bottom: 40px;">
        <div class="footer-menu-links">
            <div class="footer-menu-l">
                <a href="/"><?= Html::img('/images/svg/logo.svg', ['alt' => 'Logo', 'class' => 'logo-img logo_footer']) ?></a>
                <a href="/"><?= Html::img('/images/svg/mobile_logo.svg', ['alt' => 'Logo', 'class' => 'mobile_logo_footer']) ?></a>
            </div>
            <div class="footer-menu-right-l">
                <div class="footer-menu-l footer-menu-l-ahref footer-menu-right-firch">
                    <ul>
                        <li>
							<?= Html::a('Головна', ['/'], ['class' => '']) ?>
                        </li>
                        <li>
							<?= Html::a('Політика', ['/signup'], ['class' => '']) ?>
                        </li>
                    </ul>
                </div>
                <div class="footer-menu-l footer-menu-l-ahref">
                    <ul>
                        <li>
							<?= Html::a('Спільноти', ['/'], ['class' => '']) ?>
                        </li>
                        <li>
							<?= Html::a('Стрічка', ['/signup'], ['class' => '']) ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-menu-help-proj-b">
			<?= Html::a('Допомогти проекту', 'https://send.monobank.ua/jar/7BBcJLcZPC', ['class' => 'purple-b purple-back-none purpler-link-menu-footer']) ?>
        </div>
    </div>
</div>