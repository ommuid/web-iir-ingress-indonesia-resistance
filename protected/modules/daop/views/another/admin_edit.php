<?php
/**
 * Daop Anothers (daop-anothers)
 * @var $this AnotherController * @var $model DaopAnothers *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Daop Anothers'=>array('manage'),
		$model->another_id=>array('view','id'=>$model->another_id),
		'Update',
	);
?>

<div class="form">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
