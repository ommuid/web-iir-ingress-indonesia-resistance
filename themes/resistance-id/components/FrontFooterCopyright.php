<?php

class FrontFooterCopyright extends CWidget
{

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {
		//get information
		$model = OmmuSettings::model()->findByPk(1,array(
			'select' => 'site_title, site_description',
		));

		$this->render('front_footer_copyright',array(
			'model' => $model,
		));	
	}
}
