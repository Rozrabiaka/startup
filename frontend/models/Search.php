<?php

namespace frontend\models;

use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Search extends Model
{
	public $q;
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['q'], 'string'],
		];
	}

	public function formName() {
		return '';
	}
}