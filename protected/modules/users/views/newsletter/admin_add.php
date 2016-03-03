<?php
/**
 * @var $this ContactcategoryController
 * @var $model SupportContactCategory
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */
 
	$this->breadcrumbs=array(
		'Support Newsletters'=>array('manage'),
		'Add',
	);
?>

<div class="form">
	<?php echo $this->renderPartial('_admin_form', array(
		'model'=>$model,
	)); ?>
</div>
