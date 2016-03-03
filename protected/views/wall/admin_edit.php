<?php
/**
 * Ommu Walls (ommu-walls)
 * @var $this WallController * @var $model OmmuWalls *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Walls'=>array('manage'),
		$model->wall_id=>array('view','id'=>$model->wall_id),
		'Update',
	);
?>

<div class="form">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
