<?php

class MenuAccount extends CWidget
{
	public $imageDefault;

	public function init() {
		$imageDefault = 'public/users/default.png';
		if(file_exists($imageDefault))
			$this->imageDefault = Yii::app()->request->baseUrl.'/'.$imageDefault;
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() 
	{
		$model = Users::model()->findByPk(Yii::app()->user->id, array(
			'select' => 'photos, lastlogin_date',
		));
		$this->render('menu_account', array(
			'model'=>$model,	
		));	
	}
}
