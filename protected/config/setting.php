<?php
/**
 * Basic parameters information
 *
 * Modules:
 *	params
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */
return array(
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'support@ommu.co',
		'primaryLang' => 'id',
		'translateLangs' => array(
			'en_us' => 'en_us',
			'id' => 'id',
		),
		
		// timthumb replace url
		'timthumb_url_replace' => 0,
		'timthumb_url_replace_website' => 'http://ommu.co',	//default http
		// access system *from product
		'product_access_system' => 'ommu.co.core',
	),
);
?>