<?php

class SidebarStatistic extends CWidget
{
	public function init() 
	{
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
		
		//import
		Yii::import('application.extensions.gapi-google-analytics.OGapi');
		
		//get information
		$model = OmmuSettings::model()->findByPk(1,array(
			'select' => 'site_url, analytic, analytic_id, analytic_profile_id',
		));
		$configPath = YiiBase::getPathOfAlias('application.config');

		$gapi = new OGapi(Yii::app()->params['Analytics']['gserviceaccount'], $configPath.'/'.Yii::app()->params['Analytics']['gservicecertificate']);
		$token = $gapi->getToken();

		$this->render('sidebar_statistic',array(
			'model' => $model,
			'token'=>$token,
			'module'=>$module,
			'controller'=>$controller,
			'action'=>$action,
			'currentAction'=>$currentAction,
			'currentModule'=>$currentModule,
			'currentModuleAction'=>$currentModuleAction,
		));	
	}
}
