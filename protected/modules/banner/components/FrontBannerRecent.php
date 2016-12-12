<?php

class FrontBannerRecent extends CWidget
{
	public $category=null;

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {
		$module = strtolower(Yii::app()->controller->module->id);
		$controller = strtolower(Yii::app()->controller->id);
		$action = strtolower(Yii::app()->controller->action->id);
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		
		//import model
		Yii::import('application.modules.banner.models.Banners');
		Yii::import('application.modules.banner.models.BannerCategory');

		$criteria=new CDbCriteria;
		$criteria->condition = 'publish = :publish AND (expired_date >= curdate() OR published_date >= curdate())';
		$criteria->params = array(
			':publish'=>1, 
		);
		$criteria->order = 'published_date DESC';
		if($this->category != null)
			$criteria->compare('cat_id',$this->category);
			
		$model = Banners::model()->findAll($criteria);

		$this->render('front_banner_recent',array(
			'model' => $model,
			'category' => $category,
		));
	}
}
