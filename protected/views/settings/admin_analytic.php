<?php
/**
 * Ommu Settings (ommu-settings)
 * @var $this SettingsController
 * @var $model OmmuSettings
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
		'Ommu Settings'=>array('manage'),
		'Manage',
	);
?>

<div class="form" name="post-on">

	<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
		'id'=>'ommu-settings-form',
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
			<?php echo $form->labelEx($model,'analytic'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'analytic'); ?>
				<?php echo $form->error($model,'analytic'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<label>
				<?php echo $model->getAttributeLabel('analytic_id');?> <span class="required">*</span>
				<span><?php echo Yii::t('phrase', 'Enter the Website Profile ID to use Google Analytics.');?></span>
			</label>
			<div class="desc">
				<?php echo $form->textField($model,'analytic_id',array('maxlength'=>32)); ?>
				<?php echo $form->error($model,'analytic_id'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<label>
				<?php echo $model->getAttributeLabel('analytic_profile_id');?> <span class="required">*</span>
			</label>
			<div class="desc">
				<?php echo $form->textField($model,'analytic_profile_id',array('maxlength'=>32)); ?>
				<?php echo $form->error($model,'analytic_profile_id'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
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