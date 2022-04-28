<?php

use common\widgets\FooterMenuWidget;
use yii\bootstrap4\Html; ?>

<div class="col-lg-4">
    <div class="left-profile-menu">
        <h5 class="mh-block-dark"><?= Html::img('/images/svg/plus.svg', ['alt' => 'My history']) ?><?= Html::a('Створити публікацію', ['/profile']) ?></h5>
        <ul class="menu-back profile-menu">
            <li>
				<?= Html::img('/images/svg/my-history.svg', ['alt' => 'My history']) ?><?= Html::a('Мої історії', ['/profile/my-history']) ?>
            </li>
            <li>
				<?= Html::img('/images/svg/settings.svg', ['alt' => 'My history']) ?><?= Html::a('Налаштування', ['/profile/settings']) ?>
            </li>
        </ul>
    </div>
	<?= FooterMenuWidget::widget() ?>
</div>
