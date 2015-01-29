<?php

class AdminDashboardStatistic extends CWidget
{

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {
		$model = OmmuSettings::model()->findByPk(1,array(
			'select' => 'site_type, license_key, site_creation, ommu_version'
		));

		$this->render('admin_dashboard_statistic', array(
			'model'=>$model,	
		));	
	}
}
