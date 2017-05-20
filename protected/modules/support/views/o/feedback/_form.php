<?php
/**
 * Support Feedbacks (support-feedbacks)
 * @var $this FeedbackController
 * @var $model SupportFeedbacks
 * @var $form CActiveForm
 * version: 0.2.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Support
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'support-feedbacks-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<div class="dialog-content">

	<fieldset>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>

		<div class="clearfix info">
			<?php echo $form->labelEx($model,'displayname'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'displayname',array('maxlength'=>32,'class'=>'span-7'));?>
				<?php echo $form->error($model,'displayname');?>
			</div>
		</div>

		<div class="clearfix info">
			<?php echo $form->labelEx($model,'email'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'email',array('maxlength'=>32,'class'=>'span-7'));?>
				<?php echo $form->error($model,'email');?>
			</div>
		</div>

		<div class="clearfix info">
			<?php echo $form->labelEx($model,'phone'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'phone',array('maxlength'=>15,'class'=>'span-5'));?>
				<?php echo $form->error($model,'phone');?>
			</div>
		</div>

		<div class="clearfix info">
			<?php echo $form->labelEx($model,'subject'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'subject',array('maxlength'=>64,'class'=>'span-10'));?>
				<?php echo $form->error($model,'subject');?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'message'); ?>
			<div class="desc">
				<?php 
				//echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50, 'class'=>'span-11 smaller'));
				$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
					'model'=>$model,
					'attribute'=>message,
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
				<?php echo $form->error($model,'message'); ?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>

<?php $this->endWidget(); ?>
