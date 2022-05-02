<?php

use common\widgets\ProfileMenuWidget;
use common\widgets\ProfileTopMenuWidget;

?>
<div class="profile">
	<div class="row">
		<?= ProfileTopMenuWidget::widget() ?>
		<?= ProfileMenuWidget::widget() ?>
		<div class="col-lg-8">
			<h5 class="mh-block-dark">Мої публікації</h5>
		</div>
	</div>
</div>