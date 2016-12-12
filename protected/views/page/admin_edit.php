<?php
/**
 * Ommu Pages (ommu-pages)
 * @var $this PageController
 * @var $model OmmuPages
 * @var $form CActiveForm
 * version: 1.1.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Pages'=>array('manage'),
		$model->title=>array('view','id'=>$model->page_id),
		'Update',
	);
?>

<div class="form">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>