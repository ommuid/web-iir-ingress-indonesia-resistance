<?php
/**
 * Ommu Zone Villages (ommu-zone-village)
 * @var $this ZonevillageController
 * @var $model OmmuZoneVillage
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
	'id'=>'ommu-zone-village-form',
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
			<?php echo $form->labelEx($model,'district_id'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'district_id',array('maxlength'=>11)); ?>
				<?php echo $form->error($model,'district_id'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'village_name'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'village_name',array('maxlength'=>64)); ?>
				<?php echo $form->error($model,'village_name'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'zipcode'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'zipcode',array('maxlength'=>5)); ?>
				<?php echo $form->error($model,'zipcode'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'mfdonline'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'mfdonline',array('maxlength'=>10)); ?>
				<?php echo $form->error($model,'mfdonline'); ?>
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


