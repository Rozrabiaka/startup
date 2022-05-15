<?php

$this->title = Yii::$app->name . ". Коментарі";

use common\widgets\FooterMenuWidget;
use yii\bootstrap4\Html;

?>

<div class="content comment-content">
    <div class="row">
        <div class="col-lg-4">
            <div class="content-menu mobile-none">
                <div class="post">
                    <h5 class="mh-block-dark">Інформаційний блок</h5>
                    <div class="menu-back info-block">
                        Freedom Home потребує вашої допомоги. Ми шукаємо SEO спеціаліста(ів), котрі допоможуть
                        продвинути наший проєкт в пошукових системах. Якщо маєте бажання допомогти, будь ласка,
						<?= Html::mailto('напишіть нам', 'freehomeua@gmail.com', ['class' => '']) ?>
                    </div>
                </div>
            </div>
			<?= FooterMenuWidget::widget() ?>
        </div>
        <div class="col-lg-8">
            <h5 class="mh-block-dark">Коментарі</h5>
            <div class="comment-post" style="margin-top:20px;">
                <div class="post" data-key="<?= $model->id ?>">
                    <div class="post-data">
						<?= Html::img($model->relatedRecords["user"]->img, ['alt' => 'People']) ?> <?= Html::a('<span class="post-username">' . $model->relatedRecords["user"]->username . '</span>', ['/site/profile', 'id' => $model->relatedRecords["user"]->id]) ?>
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
                    </div>
                </div>
            </div>
			<?php echo \yii2mod\comments\widgets\Comment::widget([
				'model' => $model,
				'commentView' => '@app/views/site/comments/_comment',
				'dataProviderConfig' => [
					'pagination' => [
						'pageSize' => 10
					],
				]
			]); ?>
        </div>
    </div>
</div>
