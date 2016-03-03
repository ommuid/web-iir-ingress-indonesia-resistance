<?php
/**
 * @var $this ContactcategoryController
 * @var $model SupportContactCategory
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
	'action' => Yii::app()->controller->createUrl('add'),
	'id'=>'support-contact-category-form',
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
			<?php echo $form->labelEx($model,'title'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'title',array('maxlength'=>32)); ?>
				<?php echo $form->error($model,'title'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'icons'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'icons',array('maxlength'=>32)); ?>
				<?php echo $form->error($model,'icons'); ?>
			</div>
		</div>


		<div class="clearfix">
			<?php echo $form->labelEx($model,'publish'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'publish'); ?>
				<?php echo $form->error($model,'publish'); ?>
			</div>
		</div>

		<div class="submit clearfix">
			<label>&nbsp;</label>
			<div class="desc">
				<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>

	</fieldset>
<?php $this->endWidget(); ?>
