<?php
/**
 * OmmuMeta (ommu-meta)
 * @var $this MetaController
 * @var $model OmmuMeta
 * @var $form CActiveForm
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Metas'=>array('manage'),
		$model->id=>array('view','id'=>$model->id),
		'Update',
	);
?>

<div class="form">

	<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
		'id'=>'ommu-meta-form',
		'enableAjaxValidation'=>true,
		'htmlOptions' => array('enctype' => 'multipart/form-data')
	)); ?>

	<?php //begin.Messages ?>
	<div id="ajax-message">
	<?php
		echo $form->errorSummary($model);
		if(Yii::app()->user->hasFlash('error'))
			echo Utility::flashError(Yii::app()->user->getFlash('error'));
		if(Yii::app()->user->hasFlash('success'))
			echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
	?>
	</div>
	<?php //begin.Messages ?>

	<fieldset>

		<?php if($model->meta_image != '') {
			$model->old_meta_image = $model->meta_image;
			echo $form->hiddenField($model,'old_meta_image');
			$images = Yii::app()->request->baseUrl.'/public/'.$model->old_meta_image;
			?>
			<div class="clearfix">
				<?php echo $form->labelEx($model,'old_meta_image'); ?>
				<div class="desc">
					<img src="<?php echo Utility::getTimThumb($images, 320, 150, 3);?>" alt="">
				</div>
			</div>
		<?php }?>
		
		<div class="clearfix">
			<?php echo $form->labelEx($model,'meta_image'); ?>
			<div class="desc">
				<?php echo $form->fileField($model,'meta_image',array('maxlength'=>64)); ?>
				<?php echo $form->error($model,'meta_image'); ?>
			</div>
		</div>
		
		<div class="clearfix">
			<?php echo $form->labelEx($model,'meta_image_alt'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'meta_image_alt',array('class'=>'span-7')); ?>
				<?php echo $form->error($model,'meta_image_alt'); ?>
				<span class="small-px silent"><?php echo Yii::t('phrase', 'A text description of the image conveying the essential nature of an image to users who are visually impaired');?></span>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'office_on'); ?>
			<div class="desc">
				<?php echo $form->radioButtonList($model,'office_on', array(
					1 => Yii::t('phrase', 'Enabled'),
					0 => Yii::t('phrase', 'Disabled'),
				)); ?>
				<?php echo $form->error($model,'office_on'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'google_on'); ?>
			<div class="desc">
				<?php echo $form->radioButtonList($model,'google_on', array(
					1 => Yii::t('phrase', 'Enabled'),
					0 => Yii::t('phrase', 'Disabled'),
				)); ?>
				<?php echo $form->error($model,'google_on'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'twitter_on'); ?>
			<div class="desc">
				<?php echo $form->radioButtonList($model,'twitter_on', array(
					1 => Yii::t('phrase', 'Enabled'),
					0 => Yii::t('phrase', 'Disabled'),
				)); ?>
				<?php echo $form->error($model,'twitter_on'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'facebook_on'); ?>
			<div class="desc">
				<?php echo $form->radioButtonList($model,'facebook_on', array(
					1 => Yii::t('phrase', 'Enabled'),
					0 => Yii::t('phrase', 'Disabled'),
				)); ?>
				<?php echo $form->error($model,'facebook_on'); ?>
			</div>
		</div>

		<div class="submit clearfix">
			<label>&nbsp;</label>
			<div class="desc">
				<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>

	</fieldset>
	<?php $this->endWidget(); ?>


</div>
