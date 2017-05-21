<?php
/**
 * Article Category (article-category)
 * @var $this CategoryController
 * @var $model ArticleCategory
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/mod-article
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'article-category-form',
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
			<?php echo $form->labelEx($model,'parent'); ?>
			<div class="desc">
				<?php 
				$category = ArticleCategory::getCategory();
				if($category != null)
					echo $form->dropDownList($model,'parent', $category, array('prompt'=>Yii::t('phrase', 'No Parent')));
				else
					echo $form->dropDownList($model,'parent', array(0=>Yii::t('phrase', 'No Parent')));?>
				<?php echo $form->error($model,'parent'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'title_i'); ?>
			<div class="desc">
				<?php 
				if(!$model->getErrors())
					$model->title_i = Phrase::trans($model->name);
				echo $form->textField($model,'title_i',array('maxlength'=>32,'class'=>'span-8')); ?>
				<?php echo $form->error($model,'title_i'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'description_i'); ?>
			<div class="desc">
				<?php 
				if(!$model->getErrors())
					$model->description_i = Phrase::trans($model->desc);
				echo $form->textArea($model,'description_i',array('maxlength'=>128,'class'=>'span-11 smaller')); ?>
				<?php echo $form->error($model,'description_i'); ?>
			</div>
		</div>

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'single_photo'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'single_photo'); ?>
				<?php echo $form->labelEx($model,'single_photo'); ?>
				<?php echo $form->error($model,'single_photo'); ?>
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
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>

