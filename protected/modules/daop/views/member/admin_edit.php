<?php
/**
 * Daop Users (daop-users)
 * @var $this MemberController * @var $model DaopUsers *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Daop Users'=>array('manage'),
		$model->daop_id=>array('view','id'=>$model->daop_id),
		'Update',
	);
?>

<div class="form">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
