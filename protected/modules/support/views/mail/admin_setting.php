<?php
/**
 * @var $this MailsettingController
 * @var $model SupportMailSetting
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
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
	$('#SupportMailSetting_mail_smtp input[name="SupportMailSetting[mail_smtp]"]').live('change', function() {
		var id = $(this).val();
		if(id == '1') {
			$('div#smtp').slideDown();
		} else {
			$('div#smtp').slideUp();
		}
	});
	$('#SupportMailSetting_smtp_authentication input[name="SupportMailSetting[smtp_authentication]"]').live('change', function() {
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

<div class="form" name="post-on">
	<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
		'id'=>'support-mails-form',
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
					<span><?php echo Phrase::trans(23004,1);?></span>
				</label>
				<div class="desc">
					<?php echo $form->textField($model,'mail_contact',array('maxlength'=>32,'class'=>'span-5')); ?>
					<?php echo $form->error($model,'mail_contact'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label>
					<?php echo $model->getAttributeLabel('mail_name');?> <span class="required">*</span><br/>
					<span><?php echo Phrase::trans(23006,1);?></span>
				</label>
				<div class="desc">
					<?php echo $form->textField($model,'mail_name',array('maxlength'=>32,'class'=>'span-5')); ?>
					<?php echo $form->error($model,'mail_name'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label>
					<?php echo $model->getAttributeLabel('mail_from');?> <span class="required">*</span><br/>
					<span><?php echo Phrase::trans(23008,1);?></span>
				</label>
				<div class="desc">
					<?php echo $form->textField($model,'mail_from',array('maxlength'=>32,'class'=>'span-5')); ?>
					<?php echo $form->error($model,'mail_from'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label>
					<?php echo $model->getAttributeLabel('mail_count');?> <span class="required">*</span><br/>
					<span><?php echo Phrase::trans(23010,1);?></span>
				</label>
				<div class="desc">
					<?php echo $form->textField($model,'mail_count',array('maxlength'=>32,'class'=>'span-2')); ?>
					<?php echo $form->error($model,'mail_count'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'mail_queueing'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Phrase::trans(23012,1);?></span>
					<?php echo $form->radioButtonList($model, 'mail_queueing', array(
						1 => Phrase::trans(23013,1),
						0 => Phrase::trans(23014,1),
					)); ?>
					<?php echo $form->error($model,'mail_queueing'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'mail_smtp'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Phrase::trans(23016,1);?></span>
					<?php echo $form->radioButtonList($model, 'mail_smtp', array(
						0 => Phrase::trans(23017,1),
						1 => Phrase::trans(23018,1),
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
						<span><?php echo Phrase::trans(23021,1);?></span>
					</label>
					<div class="desc">
						<?php echo $form->textField($model,'smtp_port',array('maxlength'=>16,'class'=>'span-2')); ?>
						<?php echo $form->error($model,'smtp_port'); ?>
					</div>
				</div>

				<div class="clearfix">
					<?php echo $form->labelEx($model,'smtp_authentication'); ?>
					<div class="desc">
						<span class="small-px"><?php echo Phrase::trans(23023,1);?></span>
						<?php echo $form->radioButtonList($model, 'smtp_authentication', array(
							1 => Phrase::trans(23024,1),
							0 => Phrase::trans(23025,1),
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
							0 => Phrase::trans(23027,1),
							1 => Phrase::trans(23028,1),
							2 => Phrase::trans(23029,1),
						)); ?>
						<?php echo $form->error($model,'smtp_ssl'); ?>
					</div>
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
