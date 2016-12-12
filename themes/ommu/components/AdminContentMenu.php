<?php

class AdminContentMenu extends CWidget
{

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {
		$model = Utility::getContentMenu();
		
		$this->render('admin_content_menu', array(
			'model'=>$model,
		));	
	}
}
