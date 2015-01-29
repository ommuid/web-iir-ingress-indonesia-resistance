<?php

class AdminAccount extends CWidget
{

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {

		$model = Users::model()->findByPk(Yii::app()->user->id, array(
			'select' => 'photo_id, lastlogin_date',
		));

		$this->render('admin_account', array(
			'model'=>$model,	
		));	
	}
}
