<?php
/**
 * Support Contact Category (support-contact-category)
 * @var $this ContactcategoryController
 * @var $model SupportContactCategory
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
		'Support Contact Categories'=>array('manage'),
		$model->name=>array('view','id'=>$model->cat_id),
		'Update',
	);
?>

<?php echo $this->renderPartial('/o/contact_category/_form', array(
	'model'=>$model,
)); ?>
