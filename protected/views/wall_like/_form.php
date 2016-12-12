<?php
/**
 * Ommu Wall Likes (ommu-wall-likes)
 * @var $this WalllikeController
 * @var $model OmmuWallLikes
 * @var $form CActiveForm
 * version: 1.1.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2015 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contect (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'ommu-wall-likes-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<?php //begin.Messages ?>
<div id="ajax-message">
	<?php echo $form->errorSummary($model); ?>
</div>
<?php //begin.Messages ?>

<fieldset>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'wall_id'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'wall_id',array('size'=>11,'maxlength'=>11)); ?>
			<?php echo $form->error($model,'wall_id'); ?>
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
		<?php echo $form->labelEx($model,'likes_date'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'likes_date'); ?>
			<?php echo $form->error($model,'likes_date'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'likes_ip'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'likes_ip',array('size'=>20,'maxlength'=>20)); ?>
			<?php echo $form->error($model,'likes_ip'); ?>
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


