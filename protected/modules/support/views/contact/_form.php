<?php
/**
 * @var $this ContactsController
 * @var $model SupportContacts
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'action' => Yii::app()->controller->createUrl('add'),
	'id'=>'support-contacts-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<?php //begin.Messages ?>
<div id="ajax-message">
	<?php echo $form->errorSummary($model); ?>
</div>
<?php //begin.Messages ?>

<fieldset>

	<?php if(SupportContactCategory::getCategory(1) != null) {?>
	<div class="clearfix">
		<label><?php echo $model->getAttributeLabel('cat_id');?> <span class="required">*</span></label>
		<div class="desc">
			<?php echo $form->dropDownList($model,'cat_id', SupportContactCategory::getCategory(1)); ?>
			<?php echo $form->error($model,'cat_id'); ?>
		</div>
	</div>
	<?php }?>

	<div class="clearfix">
		<label><?php echo $model->getAttributeLabel('value');?> <span class="required">*</span></label>
		<div class="desc">
			<?php echo $form->textArea($model,'value',array('rows'=>6, 'cols'=>50, 'class'=>'smaller')); ?>
			<?php echo $form->error($model,'value'); ?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'publish'); ?>
		<div class="desc">
			<?php echo $form->checkBox($model,'publish'); ?>
			<?php echo $form->error($model,'publish'); ?>
		</div>
	</div>

	<div class="submit clearfix">
		<label>&nbsp;</label>
		<div class="desc">
			<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
		</div>
	</div>

</fieldset>
<?php $this->endWidget(); ?>
