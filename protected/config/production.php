<?php
/**
 * This is the main Web application configuration. Any writable
 * CWebApplication properties can be configured here.
 *
 * uncomment the following to define a path alias
 * Yii::setPathOfAlias('local','path/to/local-folder');
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contect (+62)856-299-4114
 *
 */
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Ommu Platform',

	// Language setting
	'sourceLanguage' => '00',
	'language'       => 'id',
	'behaviors' => array('AppConfigBehavior'),

	// Language setting
	'sourceLanguage' => '00',
	'language'       => 'id',
	'behaviors' => array('AppConfigBehavior'),

	// preloading 'log' component
	'preload'=>array('log', 'ommu'),

	// autoloading model and component classes
	'import'=>array(
		// Model
		'application.models.*',
		'application.models.core.*',
		'application.modules.report.models.*',
		'application.modules.support.models.*',
		'application.modules.users.models.*',
		'application.modules.users.models.Users',
		//'application.modules.personal.models.*',

		// Components
		'application.components.*',
		'application.components.admin.*',
		'application.components.public.*',
		'application.components.system.*',
		'application.modules.users.components.*',
	),

	// application components
	'components'=>array(
		//Ommu custom components
		'ommu' => array(
			'class' => 'application.ommu.Ommu',
		),
		
		//Ommu module/plugin handle
		'moduleHandle' => array(
			'class' => 'application.ommu.ModuleHandle'
		),

		//move core message yii to protected
		'coreMessages' => array(
			'basePath' => null,
		),

		'clientScript' => array(
			'class' => 'OClientScript',
			'coreScriptPosition' => CClientScript::POS_END,
		),

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

);