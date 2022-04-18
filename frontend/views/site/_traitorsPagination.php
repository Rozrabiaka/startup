<?php

use yii\helpers\Html;
use yii\helpers\Url; ?>

<a href="<?= Url::toRoute(['site/traitor', 'id' => $model->id]); ?>">
    <div class="img-traitor">
		<?= Html::img($model->img, ['alt' => $model->name]) ?>
    </div>
    <div class="traitor-info">
        <div class="traitor-name">
			<?= $model->name ?>
        </div>
        <div class="traitor-insult">
            <span><?= $model->insult ?></span>
        </div>
        <div class="traitor-description">
			<?= $model->description ?>
        </div>
    </div>
</a>
