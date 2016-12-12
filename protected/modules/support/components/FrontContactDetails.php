<?php

class FrontContactDetails extends CWidget
{

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {
		//import model
		Yii::import('application.modules.support.models.SupportMailSetting');
		Yii::import('application.modules.support.models.SupportContacts');
		
		$model = OmmuMeta::model()->findByPk(1, array(
			'select' => 'office_place, office_village, office_district, office_city, office_province, office_country, office_zipcode, office_phone, office_fax, office_hotline, office_email'
		));

		$this->render('front_contact_details',array(
			'model'=>$model,
		));	
	}
}
