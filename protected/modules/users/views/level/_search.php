<?php
/**
 * @var $this LevelController
 * @var $model UserLevel
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
			<?php echo $model->getAttributeLabel('level_id'); ?><br/>
			<?php echo $form->textField($model,'level_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('name'); ?><br/>
			<?php echo $form->textField($model,'name',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('desc'); ?><br/>
			<?php echo $form->textField($model,'desc',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('defaults'); ?><br/>
			<?php echo $form->textField($model,'defaults'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('signup'); ?><br/>
			<?php echo $form->textField($model,'signup'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('message_allow'); ?><br/>
			<?php echo $form->textField($model,'message_allow'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('message_inbox'); ?><br/>
			<?php echo $form->textField($model,'message_inbox'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('message_outbox'); ?><br/>
			<?php echo $form->textField($model,'message_outbox'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('profile_block'); ?><br/>
			<?php echo $form->textField($model,'profile_block'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('profile_search'); ?><br/>
			<?php echo $form->textField($model,'profile_search'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('profile_privacy'); ?><br/>
			<?php echo $form->textField($model,'profile_privacy',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('profile_comments'); ?><br/>
			<?php echo $form->textField($model,'profile_comments',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('profile_style'); ?><br/>
			<?php echo $form->textField($model,'profile_style'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('profile_style_sample'); ?><br/>
			<?php echo $form->textField($model,'profile_style_sample'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('profile_status'); ?><br/>
			<?php echo $form->textField($model,'profile_status'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('profile_invisible'); ?><br/>
			<?php echo $form->textField($model,'profile_invisible'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('profile_views'); ?><br/>
			<?php echo $form->textField($model,'profile_views'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('profile_change'); ?><br/>
			<?php echo $form->textField($model,'profile_change'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('profile_delete'); ?><br/>
			<?php echo $form->textField($model,'profile_delete'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('photo_allow'); ?><br/>
			<?php echo $form->textField($model,'photo_allow'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('photo_width'); ?><br/>
			<?php echo $form->textField($model,'photo_width'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('photo_height'); ?><br/>
			<?php echo $form->textField($model,'photo_height'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('photo_exts'); ?><br/>
			<?php echo $form->textField($model,'photo_exts',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Phrase::trans(3,0)); ?>
		</li>
	</ul>
	<div class="clear"></div>
<?php $this->endWidget(); ?>
