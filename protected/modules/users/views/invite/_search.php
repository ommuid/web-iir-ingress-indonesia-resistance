<?php
/**
 * @var $this InviteController
 * @var $model UserInvites
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('invite_id'); ?><br/>
			<?php echo $form->textField($model,'invite_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('queue_id'); ?><br/>
			<?php echo $form->textField($model,'queue_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('user_id'); ?><br/>
			<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('code'); ?><br/>
			<?php echo $form->textField($model,'code',array('size'=>16,'maxlength'=>16)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('invite_date'); ?><br/>
			<?php echo $form->textField($model,'invite_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('invite_ip'); ?><br/>
			<?php echo $form->textField($model,'invite_ip',array('size'=>20,'maxlength'=>20)); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Phrase::trans(3,0)); ?>
		</li>
	</ul>
	<div class="clear"></div>
<?php $this->endWidget(); ?>
