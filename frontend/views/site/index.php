<?php

/** @var yii\web\View $this */

/** @var common\models\History $dataProvider */

use common\widgets\FooterMenuWidget;
use common\widgets\SorterWidget;
use kop\y2sp\ScrollPager;
use yii\bootstrap4\Html;
use yii\widgets\ListView;

$this->title = Yii::$app->name;
?>
<?php if (Yii::$app->user->isGuest): ?>
    <div class="index-top">
        <div class="row">
            <div class="col-lg-6">
                <h1>Що таке Freedom Home?</h1>

                <p>Це найкраща українська платформа для розповсюдження ваших історій! Багатий функціонал допоможе вам
                    дуже
                    швидко написати
                    історію із вашого життя!</p>

				<?= Html::a('Реєстрація', ['/signup'], ['class' => 'purple-b']) ?>
            </div>
            <div class="col-lg-6">
                <div class="index-img">
					<?= Html::img('/images/people.png', ['alt' => 'People']) ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="content history-content">
    <div class="row">
        <div class="col-lg-4">
            <div class="filter">
                <h5 class="mh-block-dark">Сортувати за: </h5>
                <div class="menu-back">
					<?php echo SorterWidget::widget(array(
						'sort' => $dataProvider->sort,
						'type' => 'listStyleType',
						'removeAttributes' => array(
							'title', 'description', 'id', 'user_id'
						)
					)) ?>

					<?php if (!empty(Yii::$app->getRequest()->getQueryParams())): ?>
						<?= Html::a('Очистити фільтр', ['/'], ['class' => 'clear-filer']) ?>
					<?php endif; ?>
                </div>
            </div>
            <div class="content-menu mobile-none">
                <div class="post">
                    <h5 class="mh-block-dark">Інформаційний блок</h5>
                    <div class="menu-back info-block">
                        Freedom Home потребує вашої допомоги. Ми шукаємо SEO спеціаліста(ів), котрі допоможуть
                        продвинути наший проєкт в пошукових системах. Якщо маєте бажання допомогти, будь ласка,
						<?= Html::mailto('напишіть нам', 'freehomeua@gmail.com', ['class' => '']) ?>.
                        <br>
                        P.S Потребуємо модераторів, програмістів.
                    </div>
                </div>
            </div>
			<?= FooterMenuWidget::widget() ?>
        </div>
        <div class="col-lg-8">
			<?php
			echo ListView::widget([
				'dataProvider' => $dataProvider,
				'itemOptions' => ['class' => 'item'],
				'itemView' => '_indexPosts',
				'layout' => "{items}\n{pager}",
				'summary' => false,
				'pager' => [
					'class' => ScrollPager::className(),
					'noneLeftText' => 'Кінець стрічки. Чи не час зайнятись спортом?',
					'spinnerTemplate' => '
					                    <div class="d-flex justify-content-center loader-historis">
                                            <div class="spinner-border" role="status">
                                                <span class="sr-only"></span>
                                            </div>
                                        </div>
					',
					'enabledExtensions' => [ScrollPager::EXTENSION_SPINNER, ScrollPager::EXTENSION_NONE_LEFT, ScrollPager::EXTENSION_PAGING],
					'eventOnScroll' => 'function() {$(\'.ias-trigger a\').trigger(\'click\')}',
					'eventOnRendered' => 'function(){lazyLoad()}'
				]
			]);
			?>
        </div>
    </div>
</div>
<!---->
<!---->
<!--<div id="game">-->
<!--    <div class="world" data-world>-->
<!--        <div class="start-screen" data-start-screen>-->
<!--            <img src="/images/gif/on-bottle.gif">-->
<!--            <br>-->
<!--            <span class="game-text">Натисніть пробіл</span>-->
<!--        </div>-->
<!--        <img src="/images/ground.png" class="ground" data-ground>-->
<!--        <img src="/images/ground.png" class="ground" data-ground>-->
<!--        <img src="/images/putin.png" class="dino" data-dino>-->
<!--        <div class="score" data-score>0</div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!--<script src="/js/game/script.js" type="module"></script>-->