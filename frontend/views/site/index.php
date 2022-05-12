<?php

/** @var yii\web\View $this */

/** @var common\models\History $dataProvider */

use common\widgets\FooterMenuWidget;
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
            <div class="content-menu mobile-none">
                <a href="">
                    <div class="post">
                        <h5 class="mh-block-dark">Топ від адміністратора</h5>
                        <div class="post-description">
                            <h3 class="post-title">Магазины низких цен: оригиналы или подделки?</h3>

                            <p class="post-text">
								<?= Html::img('/images/people.png', ['alt' => 'People']) ?>
                                В одном из сообществ Вк попался мне такой вопрос: "в Светофоре оригинал или подделка
                                (мыло Duru,
                                мишки Барни, конфеты MilkyWay)?"Думаю, что ответ на этот вопрос волнует многих, поэтому
                                продублирую
                                и расширю свой ответ здесь.</p>
                        </div>
                        <div class="post-data">
                            <div class="cnm-pd-username">
								<?= Html::img('/images/people.png', ['alt' => 'People']) ?> <span
                                        class="post-username">Rozrabiaka</span>
                            </div>
                            <div class="cnm-pd-date">
                                <span class="post-date">16:15 21.11.2022</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
			<?= FooterMenuWidget::widget() ?>
        </div>
        <div class="col-lg-8">
			<?php
			echo ListView::widget([
				'dataProvider' => $dataProvider,
				'itemOptions' => ['class' => 'item'],
				'itemView' => '_indexPosts',
				'summary' => '',
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