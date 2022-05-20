<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $commentModel \yii2mod\comments\models\CommentModel */
/* @var $encryptedEntity string */
/* @var $formId string comment form id */
?>
<div class="comment-form-container">
	<?php $form = ActiveForm::begin([
		'options' => [
			'id' => $formId,
			'class' => 'comment-box',
		],
		'action' => Url::to(['/comment/default/create', 'entity' => $encryptedEntity]),
		'validateOnChange' => false,
		'validateOnBlur' => false,
	]); ?>

	<?php echo $form->field($commentModel, 'content', ['template' => '{input}{error}'])->textarea(['placeholder' => Yii::t('yii2mod.comments', 'Додати коментарій...'), 'rows' => 4, 'data' => ['comment' => 'content']]); ?>
	<?php echo $form->field($commentModel, 'parentId', ['template' => '{input}'])->hiddenInput(['data' => ['comment' => 'parent-id']]); ?>
    <div class="comment-box-partial">
        <div class="button-container show">
			<?php echo Html::a(Yii::t('yii2mod.comments', 'Click here to cancel reply.'), '#', ['id' => 'cancel-reply', 'class' => 'pull-right', 'data' => ['action' => 'cancel-reply']]); ?>
			<?php echo Html::submitButton(Yii::t('yii2mod.comments', 'Додати'), ['class' => 'purple-b purpler-button add-comment']); ?>
        </div>
    </div>
	<?php $form->end(); ?>
    <div class="clearfix"></div>
</div>
