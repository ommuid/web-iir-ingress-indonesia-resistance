<?php
/**
 * @var $this SettingsController
 * @var $model OmmuSettings
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
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
			<?php echo $form->labelEx($model,'signup_username'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Phrase::trans(47,0);?></span>
				<?php echo $form->radioButtonList($model, 'signup_username', array(
					1 => Phrase::trans(48,0),
					0 => Phrase::trans(49,0),
				)); ?>
				<?php echo $form->error($model,'signup_username'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'signup_photo'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Phrase::trans(8,0);?></span>
				<?php echo $form->radioButtonList($model, 'signup_photo', array(
					1 => Phrase::trans(9,0),
					0 => Phrase::trans(10,0),
				)); ?>
				<?php echo $form->error($model,'signup_photo'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'signup_approve'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Phrase::trans(12,0);?></span>
				<?php echo $form->radioButtonList($model, 'signup_approve', array(
					1 => Phrase::trans(13,0),
					0 => Phrase::trans(14,0),
				)); ?>
				<?php echo $form->error($model,'signup_approve'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'signup_welcome'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Phrase::trans(16,0);?></span>
				<?php echo $form->radioButtonList($model, 'signup_welcome', array(
					1 => Phrase::trans(17,0),
					0 => Phrase::trans(18,0),
				)); ?>
				<?php echo $form->error($model,'signup_welcome'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('signup_inviteonly');?> <span class="required">*</span></label>
			<div class="desc">
				<span class="small-px"><?php echo Phrase::trans(20,0);?></span>
				<?php echo $form->radioButtonList($model, 'signup_inviteonly', array(
					2 => Phrase::trans(21,0),
					1 => Phrase::trans(22,0),
					0 => Phrase::trans(23,0),
				)); ?>
				<?php echo $form->error($model,'signup_inviteonly'); ?>

				<span class="small-px"><?php echo Phrase::trans(24,0);?></span>
				<?php echo $form->radioButtonList($model, 'signup_checkemail', array(
					1 => Phrase::trans(25,0),
					0 => Phrase::trans(26,0),
				)); ?>
				<?php echo $form->error($model,'signup_checkemail'); ?>

				<span class="small-px"><?php echo Phrase::trans(27,0);?></span>
				<?php echo $form->textField($model,'signup_numgiven'); ?>&nbsp;&nbsp;<?php echo Phrase::trans(28,0);?>
				<?php echo $form->error($model,'signup_numgiven'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'signup_invitepage'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Phrase::trans(31,0);?></span>
				<?php echo $form->radioButtonList($model, 'signup_invitepage', array(
					1 => Phrase::trans(32,0),
					0 => Phrase::trans(33,0),
				)); ?>
				<?php echo $form->error($model,'signup_invitepage'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'signup_verifyemail'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Phrase::trans(35,0);?></span>
				<?php echo $form->radioButtonList($model, 'signup_verifyemail', array(
					1 => Phrase::trans(36,0),
					0 => Phrase::trans(37,0),
				)); ?>
				<?php echo $form->error($model,'signup_verifyemail'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'spam_signup'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Phrase::trans(55,0);?></span>
				<?php echo $form->radioButtonList($model, 'spam_signup', array(
					1 => Phrase::trans(56,0),
					0 => Phrase::trans(57,0),
				)); ?>
				<?php echo $form->error($model,'spam_signup'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'signup_random'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Phrase::trans(39,0);?></span>
				<?php echo $form->radioButtonList($model, 'signup_random', array(
					1 => Phrase::trans(40,0),
					0 => Phrase::trans(41,0),
				)); ?>
				<?php echo $form->error($model,'signup_random'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'signup_terms'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Phrase::trans(43,0);?></span>
				<?php echo $form->radioButtonList($model, 'signup_terms', array(
					1 => Phrase::trans(44,0),
					0 => Phrase::trans(45,0),
				)); ?>
				<?php echo $form->error($model,'signup_terms'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'signup_adminemail'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Phrase::trans(51,0);?></span>
				<?php echo $form->radioButtonList($model, 'signup_adminemail', array(
					1 => Phrase::trans(52,0),
					0 => Phrase::trans(53,0),
				)); ?>
				<?php echo $form->error($model,'signup_adminemail'); ?>
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

</div>