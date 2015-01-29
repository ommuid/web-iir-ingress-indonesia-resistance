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
	'id'=>'support-contacts-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<div class="dialog-content">

	<fieldset>

		<?php 
		if($model->cat->publish != '2') {
		if(SupportContactCategory::getCategory(1) != null) {?>
		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('cat_id');?> <span class="required">*</span></label>
			<div class="desc">
			<?php echo $form->dropDownList($model,'cat_id', SupportContactCategory::getCategory(1)); ?>
				<?php echo $form->error($model,'cat_id'); ?>
			</div>
		</div>
		<?php }
		}?>

		<div class="clearfix">
			<?php if($model->cat->publish != '2') {?>
				<label><?php echo $model->getAttributeLabel('value');?> <span class="required">*</span></label>
			<?php } else {?>
				<label><?php echo Phrase::trans($model->cat->name, 2);?> <span class="required">*</span></label>
			<?php }?>
			<div class="desc">
				<?php echo $form->textArea($model,'value',array('rows'=>6, 'cols'=>50, 'class'=>'span-11 smaller')); ?>
				<?php echo $form->error($model,'value'); ?>
			</div>
		</div>

		<?php if($model->cat->publish != 2) {?>
		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'publish'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'publish'); ?>
				<?php echo $form->labelEx($model,'publish'); ?>
				<?php echo $form->error($model,'publish'); ?>
			</div>
		</div>
		<?php }?>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0) ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>

