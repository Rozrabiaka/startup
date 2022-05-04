<?php

use common\widgets\ProfileMenuWidget;
use common\widgets\ProfileTopMenuWidget;

$this->title = 'Freedom Home. Мої історії';
?>

<div class="profile">
    <div class="row">
		<?= ProfileTopMenuWidget::widget() ?>
		<?= ProfileMenuWidget::widget() ?>
        <div class="col-lg-8">
            <h5 class="mh-block-dark">Мої публікації</h5>
            <div class="create-history profile-right-content">
                Posts must be here
            </div>
        </div>
    </div>
</div>