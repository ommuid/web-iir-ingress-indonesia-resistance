<?php

class LanguageFlag extends CWidget
{

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {
		//get information
		$model = OmmuLanguages::getLanguage(null, 'data');

		$this->render('language_flag',array(
			'model' => $model,
		));	
	}
}
