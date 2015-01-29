<?php

class FrontGoogleAnalytics extends CWidget
{

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {
		
		$model = OmmuSettings::model()->findByPk(1,array(
			'select' => 'site_url, analytic, analytic_id',
		));

		$this->render('front_google_analytics',array(
			'model' => $model,
		));	
	}
}
