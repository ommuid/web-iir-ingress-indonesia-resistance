<?php
/**
 * Database information
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */
return array(
	'components'=>array(
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=db.name',
			//'emulatePrepare' => true,
			'username' => 'db.username',
			'password' => 'db.password',
			'charset' => 'utf8',
		),
	),
);
?>