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
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('comment_id'); ?><br/>
			<?php echo $form->textField($model,'comment_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publish'); ?><br/>
			<?php echo $form->textField($model,'publish'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('dependency'); ?><br/>
			<?php echo $form->textField($model,'dependency'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('plugin_id'); ?><br/>
			<?php echo $form->textField($model,'plugin_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('content_id'); ?><br/>
			<?php echo $form->textField($model,'content_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('user_id'); ?><br/>
			<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('author_id'); ?><br/>
			<?php echo $form->textField($model,'author_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('reply'); ?><br/>
			<?php echo $form->textField($model,'reply'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('comment'); ?><br/>
			<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_date'); ?><br/>
			<?php echo $form->textField($model,'creation_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_date'); ?><br/>
			<?php echo $form->textField($model,'modified_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_id'); ?><br/>
			<?php echo $form->textField($model,'modified_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Phrase::trans(3,0)); ?>
		</li>
	</ul>
	<div class="clear"></div>
<?php $this->endWidget(); ?>
