<?php

/** @var \yii\web\View $this */

/** @var string $content */

use common\widgets\Alert;
use common\widgets\FooterBottomWidget;
use common\widgets\SearchWidget;
use frontend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
		<?= $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/svg+xml', 'href' => '/images/svg/logo.svg']); ?>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
    </head>
    <body class="d-flex flex-column">
	<?php $this->beginBody() ?>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-header">
                        <div class="align-start">
                            <a href="/"><?= Html::img('/images/svg/logo.svg', ['alt' => 'Logo', 'class' => 'logo-img pc-logo']) ?></a>
                            <a href="/"><?= Html::img('/images/svg/mobile_logo.svg', ['alt' => 'Logo', 'class' => 'mobile_logo']) ?></a>
                        </div>
                        <div class="align-center">
							<?= Html::a('Головна', ['/'], ['class' => '']) ?>
							<?= Html::a('Спільноти', ['/site/communities'], ['class' => '']) ?>
                        </div>
                        <div class="align-end">
							<?= SearchWidget::widget() ?>
                            <div class="rg-header">
                                <a href="/profile"><?= Html::img('/images/svg/user.svg', ['alt' => 'Logo']) ?></a>
                            </div>
                            <div class="rg-header mobile-menu">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect width="40" height="40" rx="2" fill="#9772FF"/>
                                    <rect x="9" y="13" width="22" height="2" rx="1" fill="#F5F7FF"/>
                                    <rect x="9" y="19" width="22" height="2" rx="1" fill="#F5F7FF"/>
                                    <rect x="9" y="25" width="22" height="2" rx="1" fill="#F5F7FF"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="mobile-menu-block">
        <div class="mobile-overlay-wrapper">
            <div class="mobile-overlay-pane">
                <div class="drawer">
                    <div class="drawer-content">
                        <div class="close-mmb">
                            <span class="click-close-mmb"><?= Html::img('/images/svg/close-mmb.svg', ['alt' => 'Close mmb']) ?></span>
                        </div>
						<?php if (!Yii::$app->user->isGuest): ?>
                            <div class="drawer-user-info">
                                <div class="drawer-user-img">
									<?= Html::img(Yii::$app->user->identity->img, ['alt' => 'Close mmb']) ?>
                                </div>
                                <div class="drawer-user-params">
                                    <span class="mmb-username"><?= Yii::$app->user->identity->username ?></span>
                                    <span class="mmb-email"><?= Yii::$app->user->identity->email ?></span>
                                </div>
                            </div>
						<?php endif; ?>

                        <div class="mmb-links">
                            <ul>
                                <li><?= Html::a('Головна', ['/'], ['class' => '']) ?></li>
                                <li><?= Html::a('Спільноти', ['/'], ['class' => '']) ?></li>
                            </ul>
                        </div>

                        <div class="mmb-b">
                            <div class="mmb-buttons">
								<?php if (Yii::$app->user->isGuest): ?>
									<?= Html::a('Реєстрація', ['/signup'], ['class' => 'purple-b mmb-b-registration']) ?>
									<?= Html::a('Вхід', ['/signup'], ['class' => 'black-b']) ?>
								<?php else: ?>
									<?php
									echo Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
										. Html::submitButton(
											'Вихід',
											['class' => 'black-b black-b-button']
										)
										. Html::endForm()
									?>
								<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main role="main" class="flex-shrink-0">
        <div class="container">
			<?= Alert::widget() ?>
			<?= $content ?>
        </div>
    </main>

	<?= FooterBottomWidget::widget() ?>

	<?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
