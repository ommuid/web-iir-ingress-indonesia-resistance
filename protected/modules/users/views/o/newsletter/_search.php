<?php
/**
 * User Newsletter (user-newsletter)
 * @var $this NewsletterController
 * @var $model UserNewsletter
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
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>		
		<li>
			<?php echo $model->getAttributeLabel('newsletter_id'); ?><br/>
			<?php echo $form->textField($model,'newsletter_id'); ?>
		</li>
		
		<li>
			<?php echo $model->getAttributeLabel('status'); ?><br/>
			<?php echo $form->textField($model,'status'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('user_id'); ?><br/>
			<?php echo $form->textField($model,'user_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('email'); ?><br/>
			<?php echo $form->textField($model,'email'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('subscribe_date'); ?><br/>
			<?php echo $form->textField($model,'subscribe_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('subscribe_id'); ?><br/>
			<?php echo $form->textField($model,'subscribe_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_date'); ?><br/>
			<?php echo $form->textField($model,'modified_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_id'); ?><br/>
			<?php echo $form->textField($model,'modified_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('updated_date'); ?><br/>
			<?php echo $form->textField($model,'updated_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('updated_ip'); ?><br/>
			<?php echo $form->textField($model,'updated_ip'); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
	<div class="clear"></div>
<?php $this->endWidget(); ?>
