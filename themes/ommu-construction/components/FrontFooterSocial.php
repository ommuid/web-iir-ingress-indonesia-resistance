<?php

class FrontFooterSocial extends CWidget
{

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {
		//import model
		Yii::import('application.modules.support.models.SupportContactCategory');
		Yii::import('application.modules.support.models.SupportContacts');

		$model = SupportContacts::model()->findAll(array(
			//'select' => 'publish, name',
			'condition' => 'publish = :publish',
			'params' => array(
				':publish' => 1,
			),
			//'order' => 'id ASC'
		));

		$this->render('front_footer_social',array(
			'model' => $model,
		));	
	}
}
