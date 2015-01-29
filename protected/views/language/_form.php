<?php
/**
 * @var $this LanguageController
 * @var $model OmmuLanguages
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
	'id'=>'ommu-languages-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<div class="dialog-content">

	<fieldset>

		<?php echo $form->errorSummary($model); ?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'code'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'code',array('maxlength'=>8)); ?>
				<?php echo $form->error($model,'code'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'name'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'name',array('maxlength'=>32)); ?>
				<?php echo $form->error($model,'name'); ?>
			</div>
		</div>

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'actived'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'actived'); ?>
				<?php echo $form->labelEx($model,'actived'); ?>
				<?php echo $form->error($model,'actived'); ?>
			</div>
		</div>

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'defaults'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'defaults'); ?>
				<?php echo $form->labelEx($model,'defaults'); ?>
				<?php echo $form->error($model,'defaults'); ?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>

