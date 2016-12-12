<?php
/**
 * ApplicationConfigBehavior is a behavior for the application.
 * It loads additional config parameters that cannot be statically 
 * written in config/main
 *
 * url: http://www.yiiframework.com/wiki/208/how-to-use-an-application-behavior-to-maintain-runtime-configuration/
 */
 
class AppConfigBehavior extends CBehavior
{
	/**
	* Declares events and the event handler methods
	* See yii documentation on behavior
	*/
	public function events()
	{
		return array_merge(parent::events(), array(
			'onBeginRequest'=>'beginRequest',
		));
	}

	/**
	* Load configuration that cannot be put in config/main
	*/
	public function beginRequest()
	{
		if($this->owner->user->getState('applicationLanguage'))
			$this->owner->language = $this->owner->user->getState('applicationLanguage');
		else
			$this->owner->language = Utility::getLanguage();
	}
}