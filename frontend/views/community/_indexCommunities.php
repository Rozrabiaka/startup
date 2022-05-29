<?php

use yii\helpers\Html; ?>
<div class="community-list">
    <div class="community-field">
        <div class="community-info">
			<?= Html::img($model->img, ['alt' => $model->name]) ?>
            <div class="right-com-info">
                <span class="community-name"><?= $model->name ?></span>
                <span class="community-count">1 222 222 підписників</span>
            </div>
        </div>
        <div class="community-button">
			<?= Html::a('Редагувати', ['/profile/edit-community', 'id' => $model->id], ['class' => 'purple-b b-community']) ?>
        </div>
    </div>
</div>