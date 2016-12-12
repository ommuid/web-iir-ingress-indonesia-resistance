<?php
/**
 * Support Widgets (support-widget)
 * @var $this WidgetController
 * @var $model SupportWidget
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 3 February 2016, 12:26 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'support-widget-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<div class="dialog-content">
	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php echo $form->errorSummary($model); ?>
	</div>
	<?php //begin.Messages ?>

	<fieldset>

		<?php 
		if($model->cat_TO->publish != 2) {
			$category = SupportContactCategory::getCategory(1, 'widget');
			if($category != null) {?>
			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('cat_id');?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->dropDownList($model,'cat_id', $category, array('prompt'=>'')); ?>
					<?php echo $form->error($model,'cat_id'); ?>
				</div>
			</div>
			<?php }
		}?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'widget_source'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'widget_source',array('rows'=>6, 'cols'=>50,'class'=>'span-10')); ?>
				<?php echo $form->error($model,'widget_source'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'publish'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'publish'); ?>
				<?php echo $form->labelEx($model,'publish'); ?>
				<?php echo $form->error($model,'publish'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>


