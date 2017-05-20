<?php
/**
 * Support Contacts (support-contacts)
 * @var $this ContactsController
 * @var $model SupportContacts
 * @var $form CActiveForm
 * version: 0.2.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Support
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Support Contacts'=>array('manage'),
		$model->id=>array('view','id'=>$model->id),
		'Update',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
