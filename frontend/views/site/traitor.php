<?php
/** @var \frontend\controllers\SiteController $traitor */
/** @var \frontend\controllers\SiteController $traitorsMore */

$this->title = Yii::$app->name . ' зрадники, мародери, покидьки';

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="traitor tr-ap row">
    <div class="traitor-image col-lg-4">
		<?= Html::img($traitor->img, ['alt' => $traitor->name]) ?>
        <div class="triangle"><?= $traitor->insult ?></div>
    </div>
    <div class="traitor-content col-lg-8">
        <div class="traitor-name">
            <div><h3><?= $traitor->name ?></h3></div>
        </div>
        <div>
            <p><?= $traitor->description ?></p>
        </div>
    </div>
</div>

<div class="traitors-more">
    <h1>Можливо вас цікавлять ці покидьки</h1>
    <div class="row">
		<?php foreach ($traitorsMore as $more): ?>
            <div class="col-lg-4 traitor">
                <a href="<?= Url::toRoute(['site/traitor', 'id' => $more['id']]); ?>">
                    <div class="img-traitor">
						<?= Html::img($more['img'], ['alt' => $more['name']]) ?>
                    </div>
                    <div class="traitor-info">
                        <div class="traitor-name">
							<?= $more['name'] ?>
                        </div>
                        <div class="traitor-insult">
                            <span><?= $more['insult'] ?></span>
                        </div>
                        <div class="traitor-description">
							<?= $more['description'] ?>
                        </div>
                    </div>
                </a>
            </div>
		<?php endforeach; ?>
    </div>
</div>


