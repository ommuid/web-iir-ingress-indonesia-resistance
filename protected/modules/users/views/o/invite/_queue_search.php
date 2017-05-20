<?php
/**
 * User Invite Queue (user-invite-queue)
 * @var $this InviteController
 * @var $model UserInviteQueue
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

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('queue_id'); ?><br/>
			<?php echo $form->textField($model,'queue_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('member_id'); ?><br/>
			<?php echo $form->textField($model,'member_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('reference_id'); ?><br/>
			<?php echo $form->textField($model,'reference_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('email'); ?><br/>
			<?php echo $form->textField($model,'email',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('invite'); ?><br/>
			<?php echo $form->textField($model,'invite'); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
	<div class="clear"></div>
<?php $this->endWidget(); ?>
