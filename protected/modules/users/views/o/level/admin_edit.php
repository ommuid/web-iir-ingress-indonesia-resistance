<?php
/**
 * User Levels (user-level)
 * @var $this LevelController
 * @var $model UserLevel
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Users
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

		<h3><?php echo Yii::t('phrase', 'Level Settings');?></h3>
		<fieldset>

			<div class="intro">
				<?php echo Yii::t('phrase', 'To modify this user level, complete the following form.');?>
			</div>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('title_i');?> <span class="required">*</span></label>
				<div class="desc">
					<?php
					if(!$model->getErrors())
						$model->title_i = Phrase::trans($model->name);
					echo $form->textField($model,'title_i',array('maxlength'=>32, 'class'=>'span-7')); ?>
					<?php echo $form->error($model,'title_i'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('description_i');?> <span class="required">*</span></label>
				<div class="desc">
					<?php
					if(!$model->getErrors())
						$model->description_i = Phrase::trans($model->desc);
					echo $form->textArea($model,'description_i',array('rows'=>6, 'cols'=>50, 'class'=>'span-9 smaller')); ?>
					<?php echo $form->error($model,'description_i'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('defaults');?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->checkBox($model,'defaults'); ?>
					<?php echo $form->error($model,'defaults'); ?>
				</div>
			</div>

			<div class="submit clearfix">
				<label>&nbsp;</label>
				<div class="desc">
					<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
				</div>
			</div>

		</fieldset>

	<?php $this->endWidget(); ?>
</div>


