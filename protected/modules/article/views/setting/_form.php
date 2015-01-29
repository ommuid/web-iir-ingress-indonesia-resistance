<?php
/**
 * @var $this SettingController
 * @var $model ArticleSetting
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
	'id'=>'article-setting-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php echo $form->errorSummary($model); ?>
	</div>
	<?php //begin.Messages ?>

	<h3><?php echo Phrase::trans(26057,1);?></h3>
	<fieldset>

		<div class="clearfix">
			<label>
				<?php echo $model->getAttributeLabel('license');?> <span class="required">*</span><br/>
				<span><?php echo Phrase::trans(24016,1);?></span>
			</label>
			<div class="desc">
				<?php echo $form->textField($model,'license',array('maxlength'=>32,'class'=>'span-4','disabled'=>'disabled')); ?>
				<?php echo $form->error($model,'license'); ?>
				<span class="small-px"><?php echo Phrase::trans(28004,1);?></span>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'permission'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Phrase::trans(26007,1);?></span>
				<?php echo $form->radioButtonList($model, 'permission', array(
					1 => Phrase::trans(26008,1),
					0 => Phrase::trans(26009,1),
				)); ?>
				<?php echo $form->error($model,'permission'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'meta_description'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'meta_description',array('rows'=>6, 'cols'=>50, 'class'=>'span-7 smaller')); ?>
				<?php echo $form->error($model,'meta_description'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'meta_keyword'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'meta_keyword',array('rows'=>6, 'cols'=>50, 'class'=>'span-7 smaller')); ?>
				<?php echo $form->error($model,'meta_keyword'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'type_active'); ?>
			<div class="desc">
				<?php 
				$model->type_active = explode(',', $model->type_active);
				echo $form->checkBoxList($model,'type_active', array(
					'1=26043' => Phrase::trans(26043,1),
					'2=26044' => Phrase::trans(26044,1),
					'3=26045' => Phrase::trans(26045,1),
					'4=26046' => Phrase::trans(26046,1),
				)); ?>
				<?php echo $form->error($model,'type_active'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'headline'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'headline', array('class'=>'span-2')); ?>
				<?php echo $form->error($model,'headline'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'media_limit'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'media_limit', array('class'=>'span-2')); ?>
				<?php echo $form->error($model,'media_limit'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo Phrase::trans(26086,1);?> <span class="required">*</span></label>
			<div class="desc">
				<p><?php echo $model->getAttributeLabel('media_resize');?></p>
				<?php echo $form->radioButtonList($model, 'media_resize', array(
					0 => Phrase::trans(26089,1),
					1 => Phrase::trans(26088,1),
				)); ?>
				<?php if($model->media_resize_size != '') {
					$resizeSize = explode(',', $model->media_resize_size);
					$model->media_resize_width = $resizeSize[0];
					$model->media_resize_height = $resizeSize[1];
				}?>
				<div id="resize_size" class="mt-15 <?php echo $model->media_resize == 0 ? 'hide' : '';?>">
					<?php echo Phrase::trans(26096,1).': ';?><?php echo $form->textField($model,'media_resize_width',array('maxlength'=>4,'class'=>'span-2')); ?>&nbsp;&nbsp;&nbsp;
					<?php echo Phrase::trans(26097,1).': ';?><?php echo $form->textField($model,'media_resize_height',array('maxlength'=>4,'class'=>'span-2')); ?>
					<?php echo $form->error($model,'media_resize_size'); ?>
				</div>
				
				<p><?php echo Phrase::trans(26090,1);?></p>				
				<?php echo Phrase::trans(26096,1).': ';?><?php echo $form->textField($model,'media_large_width',array('maxlength'=>4,'class'=>'span-2')); ?>&nbsp;&nbsp;&nbsp;
				<?php echo Phrase::trans(26097,1).': ';?><?php echo $form->textField($model,'media_large_height',array('maxlength'=>4,'class'=>'span-2')); ?>
				<?php echo $form->error($model,'media_large_width'); ?>
				
				<p><?php echo Phrase::trans(26091,1);?></p>
				<?php echo Phrase::trans(26096,1).': ';?><?php echo $form->textField($model,'media_medium_width',array('maxlength'=>3,'class'=>'span-2')); ?>&nbsp;&nbsp;&nbsp;
				<?php echo Phrase::trans(26097,1).': ';?><?php echo $form->textField($model,'media_medium_height',array('maxlength'=>3,'class'=>'span-2')); ?>
				<?php echo $form->error($model,'media_medium_width'); ?>
				
				<p><?php echo Phrase::trans(26092,1);?></p>
				<?php echo Phrase::trans(26096,1).': ';?><?php echo $form->textField($model,'media_small_width',array('maxlength'=>3,'class'=>'span-2')); ?>&nbsp;&nbsp;&nbsp;
				<?php echo Phrase::trans(26097,1).': ';?><?php echo $form->textField($model,'media_small_height',array('maxlength'=>3,'class'=>'span-2')); ?>
				<?php echo $form->error($model,'media_small_width'); ?>
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
