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
			<label>
				<?php echo $model->getAttributeLabel('banned_ips');?>
				<span><?php echo Phrase::trans(66,0);?></span>
			</label>
			<div class="desc">
				<?php echo $form->textArea($model,'banned_ips',array('rows'=>6, 'cols'=>50, 'class'=>'span-10')); ?>
				<?php echo $form->error($model,'banned_ips'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label>
				<?php echo $model->getAttributeLabel('banned_emails');?>
				<span><?php echo Phrase::trans(68,0);?></span>
			</label>
			<div class="desc">
				<?php echo $form->textArea($model,'banned_emails',array('rows'=>6, 'cols'=>50, 'class'=>'span-10')); ?>
				<?php echo $form->error($model,'banned_emails'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label>
				<?php echo $model->getAttributeLabel('banned_usernames');?>
				<span><?php echo Phrase::trans(70,0);?></span>
			</label>
			<div class="desc">
				<?php echo $form->textArea($model,'banned_usernames',array('rows'=>6, 'cols'=>50, 'class'=>'span-10')); ?>
				<?php echo $form->error($model,'banned_usernames'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label>
				<?php echo $model->getAttributeLabel('banned_words');?>
				<span><?php echo Phrase::trans(72,0);?></span>
			</label>
			<div class="desc">
				<?php echo $form->textArea($model,'banned_words',array('rows'=>6, 'cols'=>50, 'class'=>'span-10')); ?>
				<?php echo $form->error($model,'banned_words'); ?>
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
			<?php echo $form->labelEx($model,'spam_invite'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Phrase::trans(74,0);?></span>
				<?php echo $form->radioButtonList($model, 'spam_invite', array(
					1 => Phrase::trans(75,0),
					0 => Phrase::trans(76,0),
				)); ?>
				<?php echo $form->error($model,'spam_invite'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('spam_login');?> <span class="required">*</span></label>
			<div class="desc">
				<span class="small-px"><?php echo Phrase::trans(78,0);?></span>
				<?php echo $form->radioButtonList($model, 'spam_login', array(
					1 => Phrase::trans(79,0),
					0 => Phrase::trans(80,0),
				)); ?>
				<?php echo $form->error($model,'spam_login'); ?>

				<span class="small-px"><?php echo Phrase::trans(81,0);?></span>
				<?php echo $form->textField($model,'spam_failedcount'); ?>&nbsp;&nbsp;<?php echo Phrase::trans(82,0);?>
				<?php echo $form->error($model,'spam_failedcount'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'spam_contact'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Phrase::trans(85,0);?></span>
				<?php echo $form->radioButtonList($model, 'spam_contact', array(
					1 => Phrase::trans(86,0),
					0 => Phrase::trans(87,0),
				)); ?>
				<?php echo $form->error($model,'spam_contact'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'spam_comment'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Phrase::trans(89,0);?></span>
				<?php echo $form->radioButtonList($model, 'spam_comment', array(
					1 => Phrase::trans(90,0),
					0 => Phrase::trans(91,0),
				)); ?>
				<?php echo $form->error($model,'spam_comment'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label>
				<?php echo $model->getAttributeLabel('general_commenthtml');?> <span class="required">*</span><br/>
				<span><?php echo Phrase::trans(93,0);?></span>
			</label>
			<div class="desc">
				<?php echo $form->textField($model,'general_commenthtml',array('maxlength'=>256)); ?>
				<?php echo $form->error($model,'general_commenthtml'); ?>
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