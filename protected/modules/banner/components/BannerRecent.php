<?php
/**
 * BannerRecent
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/mod-banner
 * @contact (+62)856-299-4114
 *
 */

class BannerRecent extends CWidget
{
	public $category=null;

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() 
	{
		$module = strtolower(Yii::app()->controller->module->id);
		$controller = strtolower(Yii::app()->controller->id);
		$action = strtolower(Yii::app()->controller->action->id);
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		$currentModule = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id);
		$currentModuleAction = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);		
		
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

		$this->render('banner_recent',array(
			'model' => $model,
			'category' => $category,
			'module'=>$module,
			'controller'=>$controller,
			'action'=>$action,
			'currentAction'=>$currentAction,
			'currentModule'=>$currentModule,
			'currentModuleAction'=>$currentModuleAction,
		));
	}
}
