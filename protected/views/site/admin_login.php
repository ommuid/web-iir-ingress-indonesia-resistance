<?php
/**
 * @var $this SiteController
 * @var $model LoginForm
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Login',
	);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo $form->labelEx($model,'email'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'email', array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('email'))); ?>
				<?php echo $form->error($model,'email'); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo $form->labelEx($model,'password'); ?>
			<div class="desc">
				<?php echo $form->passwordField($model,'password', array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('password'))); ?>
				<?php echo $form->error($model,'password'); ?>
			</div>
		</div>
		<div class="clearfix">
			<label></label>
			<div class="desc">
				<?php echo CHtml::submitButton('Login', array('onclick' => 'setEnableSave()', 'class'=>'blue-button')); ?>
			</div>
		</div>
	</fieldset>
<?php $this->endWidget(); ?>
