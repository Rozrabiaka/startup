<?php
/** @var \frontend\controllers\SiteController $pagination */
/** @var \frontend\controllers\SiteController $dataProvider */

$this->title = Yii::$app->name . ' зрадники, мародери, покидьки';

use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>

<div class="traitors-search-form">
	<?php $form = ActiveForm::begin(['method' => 'get', 'action' => '/traitors', 'validateOnBlur' => false]); ?>
    <div class="row">
        <div class="col-lg-6 offset-md-3">
            <div class="search">
				<?= $form->field($model, 'q')->textInput(['maxlength' => true, 'placeholder' => "Прізвище, ім'я або по батькові", 'value' => $q])->label(false) ?>
                <div class="form-group field-b">
					<?= Html::submitButton('Пошук', ['class' => 'blue-b b-search']) ?>
                </div>
            </div>
        </div>
    </div>
	<?php ActiveForm::end(); ?>
</div>

<?php echo \yii\widgets\ListView::widget([
	'dataProvider' => $dataProvider,
	'itemView' => '_traitorsPagination.php',
	'options' => [
		'tag' => 'div',
		'class' => 'row shop_wrapper grid_3 traitors',
	],
	'emptyText' => '
                <h3>Вибачте, нам не вдалось зайнти падлюку "' . $q . '" за вашим запитом.</h3>
                <p>Якщо ви щось знаєте про цю скотину, <a href="/contact">напишіть обов\'язково нам</a> або <a href="/add-traitor">заповніть анкету</a></p>
    ',
	'itemOptions' => [
		'tag' => 'div',
		'class' => 'col-lg-12 col-md-12 traitor',
	],
	'summary' => '',
]) ?>


