<?php

use yii\bootstrap4\Html; ?>

<div class="post">
    <div class="post-data">
		<?= Html::img('/images/people.png', ['alt' => 'People']) ?> <span
                class="post-username"><?= $model->relatedRecords['user']->username ?></span>
        <span class="post-date">Опубліковано о <?= $model->datetime ?></span>
    </div>
    <div class="post-description">
        <h3 class="post-title"><?= $model->title ?></h3>

        <div class="post-text">
			<?= $model->description ?>
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
		<?= Html::a('Дивитись повністю', ['/history', 'id' => $model->id], ['class' => 'watch-more']) ?>
    </div>
</div>

