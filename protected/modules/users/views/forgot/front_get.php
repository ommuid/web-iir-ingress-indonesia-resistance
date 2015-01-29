<?php
/**
 * @var $this ForgotController
 * @var $model UserForgot
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */
 
	$this->breadcrumbs=array(
	'User Forgots'=>array('manage'),
		'Create',
	);

if(isset($_GET['name']) && isset($_GET['email'])) {
	if(isset($_GET['type']) && $_GET['type'] == 'success') {
		echo '<a class="button" href="'.Yii::app()->createUrl('site/login').'" title="'.Phrase::trans(1006,2).'">'.Phrase::trans(1006,2).'</a>';
	}
	
} else {
	echo $this->renderPartial('_form', array(
		'model'=>$model,
	));
}?>