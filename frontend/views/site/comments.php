<?php

$this->title = Yii::$app->name . ". Коментарі";

use common\widgets\FooterMenuWidget;
use yii\bootstrap4\Html;

?>

<div class="content comment-content">
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
            <h5 class="mh-block-dark">Коментарі</h5>
            <div class="comment-post" style="margin-top:20px;">
                <div class="post" data-key="<?= $model->id ?>">
                    <div class="post-data">
						<?= Html::img('/images/people.png', ['alt' => 'People']) ?> <?= Html::a('<span class="post-username">' . $model->relatedRecords["user"]->username . '</span>', ['/site/profile', 'id' => $model->relatedRecords["user"]->id]) ?>
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
