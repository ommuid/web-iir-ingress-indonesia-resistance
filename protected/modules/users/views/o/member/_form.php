<?php
/**
 * Users (users)
 * @var $this MemberController
 * @var $model Users
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Users
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'users-form',
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

		<?php if(!$model->isNewRecord) {?>
		<div class="intro">
			<?php echo Yii::t('phrase', 'To edit this users\'s account, make changes to the form below. If you want to temporarily prevent this user from logging in, you can set the user account to "disabled" below.');?>
		</div>
		<?php }?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'level_id'); ?>
			<div class="desc">
				<?php 
				$userlevel = UserLevel::getUserLevel('member');
				if($userlevel != null)
					echo $form->dropDownList($model,'level_id', $userlevel, array('prompt'=>Yii::t('phrase', 'Select User Level')));
				else
					echo $form->dropDownList($model,'level_id', array('prompt'=>Yii::t('phrase', 'Select User Level')));?>
				<?php echo $form->error($model,'level_id'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('first_name')?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->textField($model,'first_name',array('maxlength'=>32,'class'=>'span-7')); ?>
				<?php echo $form->error($model,'first_name'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('last_name')?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->textField($model,'last_name',array('maxlength'=>32,'class'=>'span-7')); ?>
				<?php echo $form->error($model,'last_name'); ?>
			</div>
		</div>

		<?php if(!$model->isNewRecord) {?>
		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('displayname')?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->textField($model,'displayname',array('maxlength'=>64,'class'=>'span-7')); ?>
				<?php echo $form->error($model,'displayname'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>
		<?php }?>

		<?php if($setting->signup_username == 1) {?>
		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('username')?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->textField($model,'username',array('maxlength'=>32,'class'=>'span-7')); ?>
				<?php echo $form->error($model,'username'); ?>
			</div>
		</div>
		<?php }?>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('email')?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->textField($model,'email',array('maxlength'=>32,'class'=>'span-7')); ?>
				<?php echo $form->error($model,'email'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<?php if($setting->signup_photo == 1) {?>
		<div class="clearfix">
			<?php echo $form->labelEx($model,'photos'); ?>
			<div class="desc">
				<?php echo $form->fileField($model,'photos'); ?>
				<?php echo $form->error($model,'photos'); ?>
				<div class="small-px silent"><?php echo Yii::t('phrase', 'Inputkan alamat url photo Anda.<br/>contoh: http://ommu.co/putrasudaryanto.jpg');?></div>
			</div>
		</div>
		<?php }?>
		
		<?php if(($model->isNewRecord && $setting->signup_random == 0) || !$model->isNewRecord) {?>
		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('newPassword')?> <?php echo $model->isNewRecord ? '<span class="required">*</span>' : '';?></label>
			<div class="desc">
				<?php echo $form->passwordField($model,'newPassword',array('maxlength'=>32,'class'=>'span-7')); ?>
				<?php echo $form->error($model,'newPassword'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('confirmPassword')?> <?php echo $model->isNewRecord ? '<span class="required">*</span>' : '';?></label>
			<div class="desc">
				<?php echo $form->passwordField($model,'confirmPassword',array('maxlength'=>32,'class'=>'span-7')); ?>
				<?php echo $form->error($model,'confirmPassword'); ?>
			</div>
		</div>
		<?php }?>

		<?php if(($model->isNewRecord && $setting->signup_approve == 0) || !$model->isNewRecord) {?>
		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'enabled'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'enabled'); ?>
				<?php echo $form->labelEx($model,'enabled'); ?>
				<?php echo $form->error($model,'enabled'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>
		<?php }?>

		<?php if(($model->isNewRecord && $setting->signup_verifyemail == 1) || !$model->isNewRecord) {?>
		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'verified'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'verified'); ?>
				<?php echo $form->labelEx($model,'verified'); ?>
				<?php echo $form->error($model,'verified'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>
		<?php }?>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>


