<?php

use common\widgets\ProfileMenuWidget;
use common\widgets\ProfileTopMenuWidget;

$this->title = 'Freedom Home. Налаштування';

?>

<div class="row">
	<?= ProfileTopMenuWidget::widget() ?>
    <?= ProfileMenuWidget::widget() ?>
	<div class="col-lg-8">
        <h5 class="mh-block-dark">Налаштування</h5>
	</div>
</div>