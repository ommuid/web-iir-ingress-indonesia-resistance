<?php
/**
 * Daop Cities (daop-city)
 * @var $this CityController
 * @var $model DaopCity
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */
?>


<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'daop-city-form',
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
			<?php echo $form->labelEx($model,'city_desc'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'city_desc',array('rows'=>6, 'cols'=>50)); ?>
				<?php echo $form->error($model,'city_desc'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'city_cover'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'city_cover',array('maxlength'=>64)); ?>
				<?php echo $form->error($model,'city_cover'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'city_photo'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'city_photo',array('maxlength'=>64)); ?>
				<?php echo $form->error($model,'city_photo'); ?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0) ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>


