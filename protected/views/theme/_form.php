<?php
/**
 * Ommu Themes (ommu-themes)
 * @var $this ThemeController
 * @var $model OmmuThemes
 * @var $form CActiveForm
 * version: 1.1.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'ommu-themes-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<div class="dialog-content">

	<fieldset>

		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'group_page'); ?>
			<div class="desc">
				<?php echo $form->dropDownList($model, 'group_page', array(
					'public' => Yii::t('phrase', 'Public'),
					'admin' => Yii::t('phrase', 'Administrator'),
					'underconstruction' => Yii::t('phrase', 'Undercontruction'),
				)); ?>
				<?php echo $form->error($model,'group_page'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'name'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'name',array('maxlength'=>32)); ?>
				<?php echo $form->error($model,'name'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'folder'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'folder',array('maxlength'=>32)); ?>
				<?php echo $form->error($model,'folder'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'layout'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'layout',array('maxlength'=>32)); ?>
				<?php echo $form->error($model,'layout'); ?>
			</div>
		</div>

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'default_theme'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'default_theme'); ?>
				<?php echo $form->labelEx($model,'default_theme'); ?>
				<?php echo $form->error($model,'default_theme'); ?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>

