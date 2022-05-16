<?php

use yii\bootstrap4\Html; ?>

<div class="post">
    <div class="post-data">
		<?= Html::img($model->img, ['alt' => 'People']) ?> <span
                class="post-username"><?= $model->username ?></span>
        <span class="post-date">Опубліковано о <?= $model->datetime ?></span>
    </div>
    <div class="post-description">
        <h3 class="post-title"><?= $model->title ?></h3>

        <div class="post-text">
            <div class="story-block">
                <div class="story-image__content">
					<?= $model->description ?>
                </div>
            </div>
        </div>

		<?php if (!empty($model->relatedRecords['historyHashtags'])): ?>
            <div class="post-hashtags">
				<?php foreach ($model->relatedRecords['historyHashtags'] as $hashtags): ?>
					<?= Html::a($hashtags->relatedRecords['hashtag']->name, ['/signup'], ['class' => 'post-hashtag']) ?>
				<?php endforeach; ?>
            </div>
		<?php endif; ?>
    </div>

    <div class="post-info">
		<?= Html::a('Читати повністю', false, ['class' => 'watch-more', 'id' => 'show-' . $model->id]) ?>
		<?= Html::a(Html::img('/images/svg/comments.svg', ['alt' => 'Comments']), ['/site/comments', 'id' => $model->id], ['class' => 'history-comments']) ?>
    </div>
</div>

