<?php

class HeaderUsermenu extends CWidget
{

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {
		
		$this->render('header_usermenu');	
		
	}
}
