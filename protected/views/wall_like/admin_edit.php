<?php
/**
 * Ommu Wall Likes (ommu-wall-likes)
 * @var $this WalllikeController * @var $model OmmuWallLikes *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
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
