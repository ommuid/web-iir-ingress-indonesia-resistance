<?php
/**
 * Ommu Menu Categories (ommu-menu-category)
 * @var $this MenucategoryController
 * @var $model OmmuMenuCategory
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 15 January 2016, 16:57 WIB
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Menu Categories'=>array('manage'),
		$model->name,
	);
?>

<div class="dialog-content">
	<?php $this->widget('application.components.system.FDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'cat_id',
			'publish',
			'orders',
			'name',
			'desc',
			'creation_date',
			'creation_id',
			'modified_date',
			'modified_id',
		),
	)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
