<?php
/**
 * Ommu Templates (ommu-template)
 * @var $this TemplateController * @var $model OmmuTemplate *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Templates'=>array('manage'),
		$model->template_key,
	);
?>

<div class="dialog-content">
	<?php $this->widget('application.components.system.FDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'template_key',
			'plugin_id',
			'user_id',
			'template',
			'variable',
			'creation_date',
			'modified_date',
			'modified_id',
		),
	)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
