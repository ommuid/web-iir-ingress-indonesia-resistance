<?php
/**
 * @var $this LevelController
 * @var $model UserLevel
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'User Levels'=>array('manage'),
		$model->name=>array('view','id'=>$model->level_id),
		'Update',
	);
?>

<div class="form" name="post-on">
	<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
		'id'=>'user-level-form',
		'enableAjaxValidation'=>true,
		//'htmlOptions' => array('enctype' => 'multipart/form-data')
	)); ?>

		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages ?>

		<h3><?php echo Phrase::trans(16013,1);?></h3>
		<fieldset>

			<div class="intro">
				<?php echo Phrase::trans(16016,1);?>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'title'); ?>
				<div class="desc">
					<?php
					$model->title = Phrase::trans($model->name, 2);
					echo $form->textField($model,'title',array('maxlength'=>32, 'class'=>'span-7')); ?>
					<?php echo $form->error($model,'title'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'description'); ?>
				<div class="desc">
					<?php
					$model->description = Phrase::trans($model->desc, 2);
					echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span-9 smaller')); ?>
					<?php echo $form->error($model,'description'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'defaults'); ?>
				<div class="desc">
					<?php echo $form->checkBox($model,'defaults'); ?>
					<?php echo $form->error($model,'defaults'); ?>
				</div>
			</div>

			<div class="submit clearfix">
				<label>&nbsp;</label>
				<div class="desc">
					<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0) ,array('onclick' => 'setEnableSave()')); ?>
				</div>
			</div>

		</fieldset>

	<?php $this->endWidget(); ?>
</div>


