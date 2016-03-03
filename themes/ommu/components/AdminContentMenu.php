<?php

class AdminContentMenu extends CWidget
{

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {
		$module = strtolower(Yii::app()->controller->module->id);
		$controller = strtolower(Yii::app()->controller->id);
		$action = strtolower(Yii::app()->controller->action->id);
		$current = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		$currentAction = $module != null ? $module.'/'.$controller.'/'.$action : $controller.'/'.$action;
		
		$module = $module != null ? $module : '-'; 
		$model = OmmuContentMenu::model()->findAll(array(
			'condition' => 'module = :m AND controller = :c AND enabled = 1',
			'params' => array(
				':m'=>$module, 
				':c'=>$controller,
			),
			//'order' => 'order'
		));
		
		
		$this->render('admin_content_menu', array(
			'model'=>$model,
			'currentAction' => $currentAction, 
			'module' => $module == '-' ? null : $module, 
			'controller' => $controller, 
			'action' => $action,
		));	
	}
}
