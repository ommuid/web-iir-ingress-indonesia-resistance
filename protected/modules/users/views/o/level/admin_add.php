<?php
/**
 * User Levels (user-level)
 * @var $this LevelController
 * @var $model UserLevel
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Users
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'User Levels'=>array('manage'),
		'Create',
	);
?>


<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'user-level-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<div class="dialog-content">

	<fieldset>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('title_i');?> <span class="required">*</span></label>
			<div class="desc">
				<?php
				if(!$model->getErrors())
					$model->title_i = Phrase::trans($model->name);
				echo $form->textField($model,'title_i',array('maxlength'=>32, 'class'=>'span-7')); ?>
				<?php echo $form->error($model,'title_i'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('description_i');?> <span class="required">*</span></label>
			<div class="desc">
				<?php
				if(!$model->getErrors())
					$model->description_i = Phrase::trans($model->desc);
				echo $form->textArea($model,'description_i',array('rows'=>6, 'cols'=>50, 'class'=>'span-9 smaller')); ?>
				<?php echo $form->error($model,'description_i'); ?>
			</div>
		</div>

		<div class="clearfix publish">
			<label><?php echo $model->getAttributeLabel('defaults');?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->checkBox($model,'defaults'); ?>
				<?php echo $form->labelEx($model,'defaults'); ?>
				<?php echo $form->error($model,'defaults'); ?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>

<?php $this->endWidget(); ?>
