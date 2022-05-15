<?php

use common\widgets\FooterMenuWidget;
use common\widgets\ProfileTopMenuWidget;
use common\widgets\SorterWidget;
use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

$this->title = Yii::$app->name . '. Профіль'

?>
<div class="profile site-user-profile">
    <div class="row">
		<?= ProfileTopMenuWidget::widget(array(
				'userId' => $userId,
                'hide' => true
			)
		) ?>
        <div class="col-lg-4">
			<?= FooterMenuWidget::widget() ?>
        </div>
        <div class="col-lg-8">
            <div class="mh-block-dark profile-settings-layout"><span
                        class="mh-block-dark-title">Публікації автора</span>
                <div class="profile-search-form">
					<?php echo SorterWidget::widget(array(
						'sort' => $dataProvider->sort,
						'removeAttributes' => array(
							'description', 'id', 'user_id'
						)
					)) ?>

					<?php $form = ActiveForm::begin(['method' => 'get', 'action' => '/site/profile/' . $userId]); ?>

					<?= $form->field($search, 'q')->textInput(['maxlength' => true, 'placeholder' => 'Пошук за титулкою'])->label(false) ?>
					<?= Html::submitButton('<svg width="20" height="20" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M15.7535 14.3789C14.5441 15.9134 12.8301 16.9696 10.9158 17.3603C9.00145 17.7509 7.01063 17.4506 5.29669 16.5127C3.58275 15.5749 2.25656 14.06 1.55353 12.2371C0.850491 10.4142 0.816082 8.40116 1.45641 6.55529C2.09674 4.70943 3.37039 3.15015 5.05127 2.15423C6.73216 1.15831 8.71155 0.790149 10.6381 1.11514C12.5647 1.44012 14.3138 2.43722 15.5749 3.92944C16.8361 5.42165 17.5278 7.31247 17.5271 9.26624C17.5268 9.84905 17.5 11.9973 15.7535 14.3789Z" stroke="#F5F7FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M15.1641 15.1666L21.0001 21.0027" stroke="#F5F7FF" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
</svg>
') ?>
					<?php ActiveForm::end(); ?>
                </div>
            </div>
			<?php
			echo ListView::widget([
				'dataProvider' => $dataProvider,
				'itemOptions' => ['class' => 'item'],
				'itemView' => '_indexPosts',
				'summary' => '',
				'pager' => [
					'nextPageLabel' => 'Далі' . Html::img('/images/svg/right.svg', ['alt' => 'People']),
					'prevPageLabel' => Html::img('/images/svg/left.svg', ['alt' => 'Left']),
					'maxButtonCount' => 3,
				],
			]);
			?>
        </div>
    </div>
</div>
