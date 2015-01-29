<?php
/**
 * @var $this AnotherdetailController
 * @var $model OmmuAnotherDetails
 * @var $form CActiveForm */
	$action = strtolower(Yii::app()->controller->action->id);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'ommu-another-details-form',
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

		<?php if($action == 'add') {?>
			<div class="clearfix">
				<?php echo $form->labelEx($model,'type'); ?>
				<div class="desc">
					<?php echo $form->dropDownList($model, 'type', array(
						0 => Phrase::trans(392,0),
						1 => Phrase::trans(393,0),
						2 => Phrase::trans(394,0),
						3 => Phrase::trans(395,0),
						4 => Phrase::trans(396,0),
					), array('prompt'=>Phrase::trans(408,0))); ?>
					<?php echo $form->error($model,'type'); ?>
				</div>
			</div>
		<?php } else {
			echo $form->hiddenField($model,'type');
		}?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'another'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'another',array('maxlength'=>64, 'class'=>'span-8')); ?>
				<?php echo $form->error($model,'another'); ?>
			</div>
		</div>

		<?php if($model->isNewRecord || (!$model->isNewRecord && $model->type != 0)) {
			$model->acreditation = $model->acreditation == '-' ? '' : $model->acreditation;
		?>
		<div id="acreditation" class="clearfix <?php echo ($model->isNewRecord || $model->type == 0) ? 'hide' : '';?>">
			<label><?php echo $model->getAttributeLabel('acreditation')?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->textField($model,'acreditation',array('maxlength'=>32, 'class'=>'span-6')); ?>
				<?php echo $form->error($model,'acreditation'); ?>
			</div>
		</div>
		<?php } else {
			echo $form->hiddenField($model,'type');
		}?>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('address')?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50, 'class'=>'span-11 smaller')); ?>
				<?php echo $form->error($model,'address'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('website')?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->textField($model,'website',array('maxlength'=>128, 'class'=>'span-8')); ?>
				<?php echo $form->error($model,'website'); ?>
			</div>
		</div>

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'publish'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'publish'); ?>
				<?php echo $form->labelEx($model,'publish'); ?>
				<?php echo $form->error($model,'publish'); ?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0) ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>
