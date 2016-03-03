<?php
/**
 * @var $this SignupController
 * @var $model Users
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
	'id'=>'users-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'class' => 'form',
		//'enctype' => 'multipart/form-data',
		//'on_post' => '',
		//'on_address' => '',
	),
)); ?>

	<fieldset>

		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages ?>

		<div class="clearfix">
			<div class="displayname">
				<?php echo $form->textField($model,'first_name',array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('first_name'))); ?>
				<?php echo $form->textField($model,'last_name',array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('last_name'))); ?>
			</div>
			<?php echo $form->error($model,'first_name'); ?>
		</div>

		<?php if($setting->signup_username == 1) {?>
		<div class="clearfix">
			<?php echo $form->textField($model,'username',array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('username'))); ?>
			<?php echo $form->error($model,'username'); ?>
		</div>
		<?php }?>

		<div class="clearfix">
			<?php echo $form->textField($model,'email',array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('email'))); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>

		<?php if($setting->signup_inviteonly != 0 && $setting->signup_checkemail == 1) {?>
		<div class="clearfix">
			<?php echo $form->textField($model,'invite_code',array('maxlength'=>16, 'placeholder'=>$model->getAttributeLabel('invite_code'))); ?>
			<?php echo $form->error($model,'invite_code'); ?>
		</div>
		<?php }?>

		<?php if($setting->signup_random != 1) {?>
		<div class="clearfix">
			<?php echo $form->passwordField($model,'old_password',array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('old_password'))); ?>
			<?php echo $form->error($model,'old_password'); ?>
		</div>

		<div class="clearfix">
			<?php echo $form->passwordField($model,'confirm_password',array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('confirm_password'))); ?>
			<?php echo $form->error($model,'confirm_password'); ?>
		</div>
		<?php }?>

		<div class="submit clearfix">
			<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(16195,1) : Phrase::trans(2,0) ,array('onclick' => 'setEnableSave()')); ?>
		</div>

	</fieldset>
<?php $this->endWidget(); ?>

