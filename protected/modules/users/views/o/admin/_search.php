<?php
/**
 * Users (users)
 * @var $this AdminController
 * @var $model Users
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
			<?php echo $model->getAttributeLabel('user_id'); ?><br/>
			<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('level_id'); ?><br/>
			<?php echo $form->textField($model,'level_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('language_id'); ?><br/>
			<?php echo $form->textField($model,'language_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('email'); ?><br/>
			<?php echo $form->textField($model,'email',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('salt'); ?><br/>
			<?php echo $form->textField($model,'salt',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('first_name'); ?><br/>
			<?php echo $form->textField($model,'first_name',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('last_name'); ?><br/>
			<?php echo $form->textField($model,'last_name',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('displayname'); ?><br/>
			<?php echo $form->textField($model,'displayname',array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('photos'); ?><br/>
			<?php echo $form->textField($model,'photos',array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('username'); ?><br/>
			<?php echo $form->textField($model,'username',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('enabled'); ?><br/>
			<?php echo $form->textField($model,'enabled'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('verified'); ?><br/>
			<?php echo $form->textField($model,'verified'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('deactivate'); ?><br/>
			<?php echo $form->textField($model,'deactivate'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('search'); ?><br/>
			<?php echo $form->textField($model,'search'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('invisible'); ?><br/>
			<?php echo $form->textField($model,'invisible'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('privacy'); ?><br/>
			<?php echo $form->textField($model,'privacy'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('comments'); ?><br/>
			<?php echo $form->textField($model,'comments'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_date'); ?><br/>
			<?php echo $form->textField($model,'creation_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_ip'); ?><br/>
			<?php echo $form->textField($model,'creation_ip',array('size'=>20,'maxlength'=>20)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_date'); ?><br/>
			<?php echo $form->textField($model,'modified_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_id'); ?><br/>
			<?php echo $form->textField($model,'modified_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('lastlogin_date'); ?><br/>
			<?php echo $form->textField($model,'lastlogin_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('lastlogin_ip'); ?><br/>
			<?php echo $form->textField($model,'lastlogin_ip',array('size'=>20,'maxlength'=>20)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('update_date'); ?><br/>
			<?php echo $form->textField($model,'update_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('update_ip'); ?><br/>
			<?php echo $form->textField($model,'update_ip',array('size'=>20,'maxlength'=>20)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('locale_id'); ?><br/>
			<?php echo $form->textField($model,'locale_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('timezone_id'); ?><br/>
			<?php echo $form->textField($model,'timezone_id'); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton('Search'); ?>
		</li>
	</ul>
	<div class="clear"></div>
<?php $this->endWidget(); ?>
