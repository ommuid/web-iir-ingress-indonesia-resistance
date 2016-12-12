<?php
/**
 * Ommu Wall Likes (ommu-wall-likes)
 * @var $this WalllikeController
 * @var $model OmmuWallLikes
 * @var $form CActiveForm
 * version: 1.1.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2015 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Wall Likes'=>array('manage'),
		$model->like_id=>array('view','id'=>$model->like_id),
		'Update',
	);
?>

<div class="form">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
