<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Ommu Platform',

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
		//'application.modules.personal.models.*',

		// Components
		'application.components.*',
		'application.components.admin.*',
		'application.components.public.*',
		'application.components.system.*',
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