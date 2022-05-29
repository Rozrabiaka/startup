<?php

use common\widgets\FooterMenuWidget;
use kop\y2sp\ScrollPager;
use yii\widgets\ListView;

$this->title = Yii::$app->name . ". Спільноти";
?>

<div class="communities">
    <div class="row">
        <div class="col-lg-4">
			<?= FooterMenuWidget::widget() ?>
        </div>
        <div class="col-lg-8">
			<?php
			echo ListView::widget([
				'dataProvider' => $dataProvider,
				'itemOptions' => ['class' => 'item'],
				'itemView' => '/community/_indexCommunities',
				'summary' => '',
				'pager' => [
					'class' => ScrollPager::className(),
					'noneLeftText' => '',
					'spinnerTemplate' => '
					                    <div class="d-flex justify-content-center loader-historis">
                                            <div class="spinner-border" role="status">
                                                <span class="sr-only"></span>
                                            </div>
                                        </div>
					',
					'enabledExtensions' => [ScrollPager::EXTENSION_SPINNER, ScrollPager::EXTENSION_NONE_LEFT, ScrollPager::EXTENSION_PAGING],
					'eventOnScroll' => 'function() {$(\'.ias-trigger a\').trigger(\'click\')}',
				]
			]);
			?>
        </div>
    </div>
</div>
