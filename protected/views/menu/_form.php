<?php
/**
 * Ommu Menus (ommu-menu)
 * @var $this MenuController
 * @var $model OmmuMenu
 * @var $form CActiveForm
 * version: 1.1.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 24 March 2016, 10:20 WIB
 * @link https://github.com/oMMu/Ommu-Core
 * @contect (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'ommu-menu-form',
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
			<?php echo $form->labelEx($model,'cat_id'); ?>
			<div class="desc">
				<?php 
				$category = OmmuMenuCategory::getCategory();
				if($category != null)
					echo $form->dropDownList($model,'cat_id', $category, array('prompt'=>Yii::t('phrase', 'Select One')));
				else
					echo $form->dropDownList($model,'cat_id', array('prompt'=>Yii::t('phrase', 'Select One'))); ?>
				<?php echo $form->error($model,'cat_id'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<?php
		$parent = null;
		$menu = OmmuMenu::getParentMenu(null, $parent);
		if($menu != null) {?>
		<div class="clearfix">
			<?php echo $form->labelEx($model,'dependency'); ?>
			<div class="desc">
				<?php echo $form->dropDownList($model,'dependency', $menu, array('prompt'=>Yii::t('phrase', 'No Parent'))); ?>
				<?php echo $form->error($model,'dependency'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>
		<?php }?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'title'); ?>
			<div class="desc">
				<?php
				$model->title = Phrase::trans($model->name, 2);
				echo $form->textField($model,'title',array('maxlength'=>32,'class'=>'span-8')); ?>
				<?php echo $form->error($model,'title'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'url'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'url',array('class'=>'span-11 smaller')); ?>
				<?php echo $form->error($model,'url'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'attr'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'attr',array('class'=>'span-11 smaller')); ?>
				<?php echo $form->error($model,'attr'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<?php /*
		<div class="clearfix">
			<?php echo $form->labelEx($model,'sitetype_access'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'sitetype_access',array('maxlength'=>32)); ?>
				<?php echo $form->error($model,'sitetype_access'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'userlevel_access'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'userlevel_access',array('maxlength'=>32)); ?>
				<?php echo $form->error($model,'userlevel_access'); ?>
			</div>
		</div>
		*/?>

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'publish'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'publish'); ?>
				<?php echo $form->labelEx($model,'publish'); ?>
				<?php echo $form->error($model,'publish'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>


