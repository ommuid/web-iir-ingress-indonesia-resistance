<?php
/**
 * Ommu Wall Comments (ommu-wall-comment)
 * @var $this WallcommentController * @var $model OmmuWallComment *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Wall Comments'=>array('manage'),
		$model->comment_id=>array('view','id'=>$model->comment_id),
		'Update',
	);
?>

<div class="form">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
