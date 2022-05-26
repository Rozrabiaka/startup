<?php

use common\widgets\PostMenuWidget;
use yii\bootstrap4\Html;

?>

<div class="post">
    <div class="post-data">
        <div>
			<?= Html::img($model->img, ['alt' => 'People']) ?>
			<?= Html::a('<span class="post-username">' . $model->username . '</span>', ['/site/profile', 'id' => $model->userId]) ?>
        </div>
        <div>
            <span class="post-date"> <?= $model->datetime ?></span>
        </div>
        <div class="post-menu">
			<?php echo PostMenuWidget::widget(array(
				'pathInfo' => Yii::$app->request->pathInfo,
				'postId' => $model->id
			)); ?>
        </div>
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
					<?= Html::a($hashtags->hashtagName, '?tag=' . $hashtags->hashtag_id, ['class' => 'post-hashtag']) ?>
				<?php endforeach; ?>
            </div>
		<?php endif; ?>
    </div>

    <div class="post-info">
		<?= Html::a('Читати повністю', false, ['class' => 'watch-more', 'id' => 'show-' . $model->id]) ?>
		<?= Html::a('<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M14.334 0C17.723 0 20 2.378 20 5.916V14.084C20 17.622 17.723 20 14.333 20H5.665C2.276 20 0 17.622 0 14.084V5.916C0 2.378 2.276 0 5.665 0H14.334ZM14.334 1.5H5.665C3.135 1.5 1.5 3.233 1.5 5.916V14.084C1.5 16.767 3.135 18.5 5.665 18.5H14.333C16.864 18.5 18.5 16.767 18.5 14.084V5.916C18.5 3.233 16.864 1.5 14.334 1.5ZM13.9482 9.0137C14.5012 9.0137 14.9482 9.4607 14.9482 10.0137C14.9482 10.5667 14.5012 11.0137 13.9482 11.0137C13.3952 11.0137 12.9432 10.5667 12.9432 10.0137C12.9432 9.4607 13.3862 9.0137 13.9382 9.0137H13.9482ZM9.9385 9.0137C10.4915 9.0137 10.9385 9.4607 10.9385 10.0137C10.9385 10.5667 10.4915 11.0137 9.9385 11.0137C9.3855 11.0137 8.9345 10.5667 8.9345 10.0137C8.9345 9.4607 9.3765 9.0137 9.9295 9.0137H9.9385ZM5.9297 9.0137C6.4827 9.0137 6.9297 9.4607 6.9297 10.0137C6.9297 10.5667 6.4827 11.0137 5.9297 11.0137C5.3767 11.0137 4.9247 10.5667 4.9247 10.0137C4.9247 9.4607 5.3677 9.0137 5.9207 9.0137H5.9297Z" fill="#F5F7FF"/>
</svg>
', ['/site/comments', 'id' => $model->id], ['class' => 'history-comments']) ?>
    </div>
</div>

