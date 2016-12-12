<?php
/**
 * Basic parameters information
 *
 * Modules:
 *	params
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contect (+62)856-299-4114
 *
 */
return array(
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'primaryLang' => 'id',
		'translateLangs' => array(
			'en' => 'en',
			'id' => 'id',
			'fr' => 'fr',
		),
		
		// timthumb replace url
		'timthumb_url_replace' => 0,		
		'timthumb_url_replace_website' => 'http://nirwasita.com',	//default http
		// access system *from product
		'product_access_system' => 'ommu.co.core',
	),
);
?>