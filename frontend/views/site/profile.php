<?php

use yii\bootstrap4\Html;

$this->title = 'Freedom Home. Профіль ' . $model->username;

?>

<div class="profile">
    <div class="row">
        <div class="col-lg-10">
            <div class="right-info">
                <div class="upload-image">
                    <form method='POST' class='upload-avatar' enctype="multipart/form-data">
						<?= Html::img($model->img, ['alt' => $model->username]) ?>
                        <div class="avatar-upload">
                            <!--                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">-->
                            <!--                            <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>-->
                            <!--                            <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>-->
                            <!--                        </svg>-->
                            <input type="file" name="avatar" class="avatar" accept="image/*">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="left-profile-menu">
                <ul>
                    <li>
						<?= Html::a('Мої історії', ['/my-history']) ?>
                    </li>
					<?php
					echo '<li>'
						. Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
						. Html::submitButton(
							'Вихід',
							['class' => 'btn btn-link logout profile-logout']
						)
						. Html::endForm()
						. '</li>';
					?>
                </ul>
            </div>
        </div>
    </div>
</div>


