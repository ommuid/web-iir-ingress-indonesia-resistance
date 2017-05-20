<?php
/**
 * Support Contacts (support-contacts)
 * @var $this ContactsController
 * @var $model SupportContacts
 * @var $form CActiveForm
 * version: 0.2.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Support
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
		if($model->cat->publish != 2) {?>
			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('cat_id');?> <span class="required">*</span></label>
				<div class="desc">
					<?php
					if($model->isNewRecord) {
						$category = SupportContactCategory::getCategory(1, 'contact');
						if($category != null)
							echo $form->dropDownList($model,'cat_id', $category, array('prompt'=>''));
						else
							echo $form->dropDownList($model,'cat_id', array('prompt'=>Yii::t('phrase', 'No Parent')));
					} else {?>
						<strong><?php echo Phrase::trans($model->cat->name); ?></strong>
					<?php }?>
					<?php echo $form->error($model,'cat_id'); ?>
				</div>
			</div>
		<?php }?>

		<div class="clearfix">
			<?php if($model->cat->publish != '2') {?>
				<label><?php echo $model->getAttributeLabel('contact_name');?> <span class="required">*</span></label>
			<?php } else {?>
				<label><?php echo Phrase::trans($model->cat->name);?> <span class="required">*</span></label>
			<?php }?>
			<div class="desc">
				<?php echo $form->textArea($model,'contact_name',array('rows'=>6, 'cols'=>50, 'class'=>'span-11 smaller')); ?>
				<?php echo $form->error($model,'contact_name'); ?>
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
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>

