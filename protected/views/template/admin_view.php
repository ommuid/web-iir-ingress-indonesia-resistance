<?php
/**
 * Ommu Templates (ommu-template)
 * @var $this TemplateController
 * @var $model OmmuTemplate
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
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
			array(
				'name'=>'plugin_id',
				'value'=>$model->plugin->name,
			),
			array(
				'name'=>'user_id',
				'value'=>$model->user->displayname,
			),
			array(
				'name'=>'template',
				'value'=>$model->template,
				'type'=>'raw',
			),
			'variable',
			'creation_date',
			'modified_date',
			array(
				'name'=>'modified_id',
				'value'=>$model->modified->displayname,
			),
		),
	)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
