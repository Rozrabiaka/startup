<?php

use kop\y2sp\ScrollPager;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this \yii\web\View */
/* @var $commentModel \yii2mod\comments\models\CommentModel */
/* @var $maxLevel null|integer comments max level */
/* @var $encryptedEntity string */
/* @var $pjaxContainerId string */
/* @var $formId string comment form id */
/* @var $commentDataProvider \yii\data\ArrayDataProvider */
/* @var $listViewConfig array */
/* @var $commentWrapperId string */

?>

<div class="comment-wrapper" id="<?php echo $commentWrapperId; ?>">
	<?php Pjax::begin(['enablePushState' => false, 'timeout' => 20000, 'id' => $pjaxContainerId]); ?>
    <div class="history-comments row">
        <div class="col-md-12 col-sm-12">
			<?php if (!Yii::$app->user->isGuest) : ?>
				<?php echo $this->render('_form', [
					'commentModel' => $commentModel,
					'formId' => $formId,
					'encryptedEntity' => $encryptedEntity,
				]); ?>
			<?php endif; ?>

			<?php echo ListView::widget(ArrayHelper::merge(
				[
					'dataProvider' => $commentDataProvider,
					'layout' => "{items}\n{pager}",
					'itemView' => '_list',
					'viewParams' => [
						'maxLevel' => $maxLevel,
					],
					'itemOptions' => ['class' => 'item comments-list'],
					'pager' => [
						'class' => ScrollPager::className(),
						'noneLeftText' => 'Ви долистали до кінця.',
						'spinnerTemplate' => '
					                    <div class="d-flex justify-content-center loader-historis">
                                            <div class="spinner-border" role="status">
                                                <span class="sr-only"></span>
                                            </div>
                                        </div>
					',
						'enabledExtensions' => [ScrollPager::EXTENSION_SPINNER, ScrollPager::EXTENSION_NONE_LEFT, ScrollPager::EXTENSION_PAGING],
						'eventOnScroll' => 'function() {$(\'.ias-trigger a\').trigger(\'click\')}',
					]
				],
				$listViewConfig
			)); ?>
        </div>
    </div>
	<?php Pjax::end(); ?>
</div>
