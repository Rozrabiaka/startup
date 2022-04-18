<?php

/** @var yii\web\View $this */

use common\widgets\QuotesWidget;
use yii\bootstrap4\Html;

$this->title = 'Traitors UA';
?>
<div class="row">
    <div class="col-lg-5">
        <div class="about">
            <h1>Про наш проект</h1>
            <p>Ми викриваємо зрадників України, мародерів та інших покидьків.
                Запрошуємо всіх охочих долучитися до проєкту.
                PS. Не забувайте про цікаву гру.</p>
            <a href="https://send.monobank.ua/jar/7BBcJLcZPC"
               target="_blank"
               class="blue-b"><?= Html::img('/images/svg/dollar.svg', ['alt' => 'Telegram']) ?>На підтримку ЗСУ</a>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="quotes">
			<?= QuotesWidget::widget() ?>
        </div>
    </div>
</div>

<div id="game">
    <div class="world" data-world>
        <div class="start-screen" data-start-screen>
            <img src="/images/gif/on-bottle.gif">
            <br>
            <span class="game-text">Натисніть пробіл</span>
        </div>
        <img src="/images/ground.png" class="ground" data-ground>
        <img src="/images/ground.png" class="ground" data-ground>
        <img src="/images/putin.png" class="dino" data-dino>
        <div class="score" data-score>0</div>
    </div>
</div>
<!-- END GAME-->

<script src="/js/game/script.js" type="module"></script>