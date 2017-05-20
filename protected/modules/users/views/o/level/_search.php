<?php
/**
 * User Levels (user-level)
 * @var $this LevelController
 * @var $model UserLevel
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
			<?php echo $model->getAttributeLabel('message_limit'); ?><br/>
			<?php echo $form->textField($model,'message_limit'); ?>
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
			<?php echo $model->getAttributeLabel('photo_size'); ?><br/>
			<?php echo $form->textField($model,'photo_size'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('photo_exts'); ?><br/>
			<?php echo $form->textField($model,'photo_exts',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
	<div class="clear"></div>
<?php $this->endWidget(); ?>
