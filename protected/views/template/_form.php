<?php
/**
 * Ommu Templates (ommu-template)
 * @var $this TemplateController
 * @var $model OmmuTemplate
 * @var $form CActiveForm
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
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
				<?php echo $form->dropDownList($model,'plugin_id', OmmuPlugins::getPlugin(null, 'id')); ?>
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
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>

<?php $this->endWidget(); ?>


