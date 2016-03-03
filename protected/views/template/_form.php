<?php
/**
 * Ommu Templates (ommu-template)
 * @var $this TemplateController * @var $model OmmuTemplate * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'ommu-template-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<div class="dialog-content">
	<fieldset>

		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages ?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'template_key'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'template_key',array('size'=>32,'maxlength'=>32)); ?>
				<?php echo $form->error($model,'template_key'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'plugin_id'); ?>
			<div class="desc">
				<?php echo $form->dropDownList($model,'plugin_id', OmmuPlugins::getPluginArray('id')); ?>
				<?php echo $form->error($model,'plugin_id'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'template'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'template',array('rows'=>6, 'cols'=>50)); ?>
				<?php echo $form->error($model,'template'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'variable'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'variable',array('rows'=>6, 'cols'=>50, 'class'=>'smaller')); ?>
				<?php echo $form->error($model,'variable'); ?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0) ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>

<?php $this->endWidget(); ?>


