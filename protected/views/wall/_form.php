<?php
/**
 * Ommu Walls (ommu-walls)
 * @var $this WallController
 * @var $model OmmuWalls
 * @var $form CActiveForm
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2015 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'ommu-walls-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<?php //begin.Messages ?>
<div id="ajax-message">
	<?php echo $form->errorSummary($model); ?>
</div>
<?php //begin.Messages ?>

<fieldset>

	<div class="clearfix publish">
		<?php echo $form->labelEx($model,'publish'); ?>
		<div class="desc">
			<?php echo $form->checkBox($model,'publish'); ?>
			<?php echo $form->labelEx($model,'publish'); ?>
			<?php echo $form->error($model,'publish'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
			<?php echo $form->error($model,'user_id'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'wall_media'); ?>
		<div class="desc">
			<?php echo $form->textArea($model,'wall_media',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'wall_media'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'wall_status'); ?>
		<div class="desc">
			<?php echo $form->textArea($model,'wall_status',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'wall_status'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'comments'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'comments'); ?>
			<?php echo $form->error($model,'comments'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'likes'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'likes'); ?>
			<?php echo $form->error($model,'likes'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'creation_date'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'creation_date'); ?>
			<?php echo $form->error($model,'creation_date'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'modified_date'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'modified_date'); ?>
			<?php echo $form->error($model,'modified_date'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="submit clearfix">
		<label>&nbsp;</label>
		<div class="desc">
			<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
		</div>
	</div>

</fieldset>
<?php /*
<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
*/?>
<?php $this->endWidget(); ?>


