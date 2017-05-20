<?php
/**
 * Ommu Wall Comments (ommu-wall-comment)
 * @var $this WallcommentController
 * @var $model OmmuWallComment
 * @var $form CActiveForm
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2015 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
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
