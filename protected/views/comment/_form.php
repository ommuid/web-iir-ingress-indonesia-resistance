<?php
/**
 * @var $this CommentController
 * @var $model OmmuComment
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
	'id'=>'ommu-comment-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<div class="dialog-content">

	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php echo $form->errorSummary($model); ?>
	</div>
	<?php //begin.Messages ?>

	<fieldset>

		<?php 
			if($model->user_id != 0) {
				$name = $model->user->displayname;
				$email = $model->user->email;
			} else {
				$name = $model->author->name;
				$email = $model->author->email;
			}
			$model->name = $name;
			echo $form->hiddenField($model,'name');
			$model->email = $email;
			echo $form->hiddenField($model,'email');
		?>

		<div class="clearfix info">
			<label><?php echo $model->getAttributeLabel('author_id')?></label>
			<div class="desc">	
				<?php echo $name;?><br/>
				<span class="small-px"><strong><?php echo $email;?></strong><br/>Date: <?php echo $model->creation_date;?></span>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'comment'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50, 'class'=>'span-11')); ?>
				<?php echo $form->error($model,'comment'); ?>
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
	<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0) ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>

<?php $this->endWidget(); ?>
