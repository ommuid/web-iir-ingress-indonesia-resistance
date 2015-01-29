<?php
/**
 * @var $this ThemeController
 * @var $model OmmuThemes
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
					'public' => Phrase::trans(229,0),
					'admin' => Phrase::trans(230,0),
					'underconstruction' => Phrase::trans(298,0),
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
	<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>

