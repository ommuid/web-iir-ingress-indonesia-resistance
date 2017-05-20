<?php
/**
 * SupportMailSetting (support-mail-setting)
 * @var $this MailsettingController
 * @var $model SupportMailSetting
 * @var $form CActiveForm
 * version: 0.2.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Support
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Support Mail Settings'=>array('manage'),
		$model->id=>array('view','id'=>$model->id),
		'Update',
	);
	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$('#SupportMailSetting_mail_smtp input[name="SupportMailSetting[mail_smtp]"]').on('change', function() {
		var id = $(this).val();
		if(id == '1') {
			$('div#smtp').slideDown();
		} else {
			$('div#smtp').slideUp();
		}
	});
	$('#SupportMailSetting_smtp_authentication input[name="SupportMailSetting[smtp_authentication]"]').on('change', function() {
		var id = $(this).val();
		if(id == '1') {
			$('div#authentication').slideDown();
		} else {
			$('div#authentication').slideUp();
		}
	});
EOP;
	$cs->registerScript('smtp', $js, CClientScript::POS_END);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'support-mail-setting-form',
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
				<?php echo $model->getAttributeLabel('mail_contact');?> <span class="required">*</span><br/>
				<span><?php echo Yii::t('phrase', 'Enter the email address you want contact form messages to be sent to.');?></span>
			</label>
			<div class="desc">
				<?php echo $form->textField($model,'mail_contact',array('maxlength'=>32,'class'=>'span-5')); ?>
				<?php echo $form->error($model,'mail_contact'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label>
				<?php echo $model->getAttributeLabel('mail_name');?> <span class="required">*</span><br/>
				<span><?php echo Yii::t('phrase', 'Enter the name you want the emails from the system to come from in the field below.');?></span>
			</label>
			<div class="desc">
				<?php echo $form->textField($model,'mail_name',array('maxlength'=>32,'class'=>'span-5')); ?>
				<?php echo $form->error($model,'mail_name'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label>
				<?php echo $model->getAttributeLabel('mail_from');?> <span class="required">*</span><br/>
				<span><?php echo Yii::t('phrase', 'Enter the email address you want the emails from the system to come from in the field below.');?></span>
			</label>
			<div class="desc">
				<?php echo $form->textField($model,'mail_from',array('maxlength'=>32,'class'=>'span-5')); ?>
				<?php echo $form->error($model,'mail_from'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label>
				<?php echo $model->getAttributeLabel('mail_count');?> <span class="required">*</span><br/>
				<span><?php echo Yii::t('phrase', 'The number of emails to send out each time the Background Mailer task is run.');?></span>
			</label>
			<div class="desc">
				<?php echo $form->textField($model,'mail_count',array('maxlength'=>32,'class'=>'span-2')); ?>
				<?php echo $form->error($model,'mail_count'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'mail_queueing'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Yii::t('phrase', 'Utilizing an email queue, you can allow your website to throttle the emails being sent out to prevent overloading the mail server.');?></span>
				<?php echo $form->radioButtonList($model, 'mail_queueing', array(
					1 => Yii::t('phrase', 'Yes, enable email queue'),
					0 => Yii::t('phrase', 'No, always send emails immediately'),
				)); ?>
				<?php echo $form->error($model,'mail_queueing'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'mail_smtp'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Yii::t('phrase', 'Emails typically get sent through the web server using the PHP mail() function. Alternatively you can have emails sent out using SMTP, usually requiring a username and password, and optionally using an external mail server.');?></span>
				<?php echo $form->radioButtonList($model, 'mail_smtp', array(
					0 => Yii::t('phrase', 'Use the built-in mail() function'),
					1 => Yii::t('phrase', 'Send emails through an SMTP server'),
				)); ?>
				<?php echo $form->error($model,'mail_smtp'); ?>
			</div>
		</div>

		<div id="smtp" <?php echo $model->mail_smtp == '0' ? 'class="hide"' : ''; ?>>
			<div class="clearfix">
				<?php echo $form->labelEx($model,'smtp_address'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'smtp_address',array('maxlength'=>32,'class'=>'span-3')); ?>
					<?php echo $form->error($model,'smtp_address'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label>
					<?php echo $model->getAttributeLabel('smtp_port');?><br/>
					<span><?php echo Yii::t('phrase', 'Default: 25. Also commonly on port 465 (SMTP over SSL) or port 587.');?></span>
				</label>
				<div class="desc">
					<?php echo $form->textField($model,'smtp_port',array('maxlength'=>16,'class'=>'span-2')); ?>
					<?php echo $form->error($model,'smtp_port'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'smtp_authentication'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Yii::t('phrase', 'Does your SMTP Server require authentication?');?></span>
					<?php echo $form->radioButtonList($model, 'smtp_authentication', array(
						1 => Yii::t('phrase', 'Yes'),
						0 => Yii::t('phrase', 'No'),
					)); ?>
					<?php echo $form->error($model,'smtp_authentication'); ?>
				</div>
			</div>
			
			<div id="authentication" <?php echo $model->smtp_authentication == '0' ? 'class="hide"' : ''; ?>>
				<div class="clearfix">
					<?php echo $form->labelEx($model,'smtp_username'); ?>
					<div class="desc">
						<?php echo $form->textField($model,'smtp_username',array('maxlength'=>32,'class'=>'span-3')); ?>
						<?php echo $form->error($model,'smtp_username'); ?>
						<?php /*<div class="small-px silent"></div>*/?>
					</div>
				</div>

				<div class="clearfix">
					<?php echo $form->labelEx($model,'smtp_password'); ?>
					<div class="desc">
						<?php echo $form->textField($model,'smtp_password',array('maxlength'=>32,'class'=>'span-3')); ?>
						<?php echo $form->error($model,'smtp_password'); ?>
						<?php /*<div class="small-px silent"></div>*/?>
					</div>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'smtp_ssl'); ?>
				<div class="desc">
					<?php echo $form->radioButtonList($model, 'smtp_ssl', array(
						0 => Yii::t('phrase', 'None'),
						1 => Yii::t('phrase', 'TLS'),
						2 => Yii::t('phrase', 'SSL'),
					)); ?>
					<?php echo $form->error($model,'smtp_ssl'); ?>
				</div>
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
