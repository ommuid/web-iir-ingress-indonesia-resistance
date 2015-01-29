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
		'Support Newsletters'=>array('manage'),
		'Unsubscribe',
	);
?>

<?php 
if(isset($_GET['success']) || (isset($_GET['email']) || isset($_GET['secret']))) {
	if($renderError == 1)
		echo '<a class="button" href="'.Yii::app()->controller->createUrl('contact/index').'" title="'.Phrase::trans(23102,1).'">'.Phrase::trans(23102,1).'</a>';
} else {
	echo $this->renderPartial('_form', array(
		'model'=>$model,
		'launch'=>$launch,
	));
}?>