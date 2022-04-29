<?php

use yii\bootstrap4\Html; ?>

<div class="footer-c">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="f-links">
                    <div>
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
                    <div class="footer-menu-help-proj-b footer-menu-bottom-proj-b">
						<?= Html::a('Допомогти проекту', 'https://send.monobank.ua/jar/7BBcJLcZPC', ['class' => 'purple-b purple-back-none purpler-link-menu-footer f-c-he']) ?>
                    </div>
                </div>
                <div class="footer-menu-help-proj-b footer-menu-bottom-mobile-proj-b">
					<?= Html::a('Допомогти проекту', 'https://send.monobank.ua/jar/7BBcJLcZPC', ['class' => 'purple-b purple-back-none purpler-link-menu-footer f-c-he']) ?>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="f-c-links">
                    <div class="f-c-link first-link">
						<?= Html::a(Html::img('/images/svg/telegram.svg', ['alt' => 'telegram', 'class' => '']) . 'Freedom Home в Telegram', 'https://t.me/+5gFPWLJC9zpiZGU0', ['class' => 'mc-social-links', 'target' => '_blank']) ?>
                    </div>
                    <div class="f-c-link">
						<?= Html::a(Html::img('/images/svg/mail.svg', ['alt' => 'telegram', 'class' => '']) . 'Наша електронна пошта', ['/signup'], ['class' => 'mc-social-links']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="down">
		<?= Html::img('/images/svg/down.svg', ['alt' => 'Down']) ?>
    </div>

    <div class="up">
		<?= Html::img('/images/svg/up.svg', ['alt' => 'Down']) ?>
    </div>
</footer>