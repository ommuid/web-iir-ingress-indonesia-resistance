<?php
/**
 * Support Feedback Replies (support-feedback-reply)
 * @var $this ReplyController
 * @var $model SupportFeedbackReply
 * @var $form CActiveForm
 * version: 0.2.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 16 February 2017, 16:00 WIB
 * @link https://github.com/ommu/Support
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'support-feedback-reply-form',
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

		<div class="clearfix info">
			<label><?php echo $model->getAttributeLabel('message')?></label>
			<div class="desc">
				<?php 
				$subject = $model->isNewRecord ? $feedback->subject : ($model->feedback->subject ? $model->feedback->subject : '-');
				echo Yii::t('phrase', 'Subject: ').$subject;?><br/>
				<?php echo $model->isNewRecord ? $feedback->message : $model->feedback->message;?><br/>
				<span class="small-px"><strong><?php echo $model->isNewRecord ? $feedback->displayname : $model->feedback->displayname;?></strong><br/><?php echo $model->isNewRecord ? $feedback->email : $model->feedback->email;?><br/>Date: <?php echo $model->isNewRecord ? $feedback->creation_date : $model->feedback->creation_date;?></span>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'reply_message'); ?>
			<div class="desc">
				<?php 
				//echo $form->textArea($model,'reply_message',array('rows'=>6, 'cols'=>50, 'class'=>'span-11 smaller'));
				$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
					'model'=>$model,
					'attribute'=>reply_message,
					// Redactor options
					'options'=>array(
						//'lang'=>'fi',
						'buttons'=>array(
							'html', 'formatting', '|', 
							'bold', 'italic', 'deleted', '|',
							'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
							'link', '|',
						),
					),
					'plugins' => array(
						'fontcolor' => array('js' => array('fontcolor.js')),
						'table' => array('js' => array('table.js')),
						'fullscreen' => array('js' => array('fullscreen.js')),
					),
				)); ?>
				<?php echo $form->error($model,'reply_message'); ?>
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
	<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>


