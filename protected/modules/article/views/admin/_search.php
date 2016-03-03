<?php
/**
 * @var $this AdminController
 * @var $model Articles
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
			<?php echo $model->getAttributeLabel('article_id'); ?><br/>
			<?php echo $form->textField($model,'article_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('cat_id'); ?><br/>
			<?php echo $form->textField($model,'cat_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('user_id'); ?><br/>
			<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publish'); ?><br/>
			<?php echo $form->textField($model,'publish'); ?>
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
			<?php echo $model->getAttributeLabel('published_date'); ?><br/>
			<?php echo $form->textField($model,'published_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('comment_code'); ?><br/>
			<?php echo $form->textField($model,'comment_code'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('comment'); ?><br/>
			<?php echo $form->textField($model,'comment'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('view'); ?><br/>
			<?php echo $form->textField($model,'view'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('media_id'); ?><br/>
			<?php echo $form->textField($model,'media_id',array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('title'); ?><br/>
			<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>256)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('body'); ?><br/>
			<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Phrase::trans(3,0)); ?>
		</li>
	</ul>
	<div class="clear"></div>
<?php $this->endWidget(); ?>
