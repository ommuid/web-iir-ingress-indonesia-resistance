<?php
/**
 * @var $this NewsletterController
 * @var $model UserNewsletter
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
			<?php echo $model->getAttributeLabel('id'); ?><br/>
			<?php echo $form->textField($model,'id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('user_id'); ?><br/>
			<?php echo $form->textField($model,'user_id',array('size'=>10,'maxlength'=>10)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('email'); ?><br/>
			<?php echo $form->textField($model,'email',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('subscribe'); ?><br/>
			<?php echo $form->textField($model,'subscribe'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('subscribe_date'); ?><br/>
			<?php echo $form->textField($model,'subscribe_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('unsubscribe_date'); ?><br/>
			<?php echo $form->textField($model,'unsubscribe_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('unsubscribe_ip'); ?><br/>
			<?php echo $form->textField($model,'unsubscribe_ip',array('size'=>20,'maxlength'=>20)); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Phrase::trans(3,0)); ?>
		</li>
	</ul>
	<div class="clear"></div>
<?php $this->endWidget(); ?>
