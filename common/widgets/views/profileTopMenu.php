<?php

use yii\bootstrap4\Html; ?>

<div class="col-lg-12">
    <div class="header-profile">
        <div class="top-profile">
            <div class="profile-img">
				<?= Html::img($userData->img, ['alt' => $userData->username]) ?>
            </div>
            <div class="profile-info">
                <span class="pfi-username"><?= $userData->username ?></span>
				<?php if (!$hide): ?>
                    <span class="pfi-email pfi-pad-top"><?= $userData->email ?> </span>
				<?php endif; ?>
                <span class="pfi-description pfi-pc pfi-pad-top"><?= $description ?></span>
            </div>
			<?php if (!$hide): ?>
                <div class="profile-logout profile-logout-pc">
					<?php
					echo Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
						. Html::submitButton(
							'Вихід',
							['class' => 'purple-b purple-back-none profile-logout-b']
						)
						. Html::endForm()
					?>
                </div>
                <div class="profile-logout profile-logout-mobile">
					<?php
					echo Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
						. Html::submitButton(
							Html::img('/images/svg/logout.svg', ['alt' => 'profile logout']),
							['class' => 'purple-b purple-back-none profile-logout-b pf-b-logout']
						)
						. Html::endForm()
					?>
                </div>
			<?php endif; ?>
        </div>
        <div class="bottom-profile">
                    <span class="pfi-description">
                        <?= $description ?>
                    </span>
        </div>
    </div>
</div>
