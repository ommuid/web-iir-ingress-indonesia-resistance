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

<?php //begin.Content ?>
<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
)); ?>
	<fieldset>
		<?php if(!isset($_GET['email'])) {?>
		<div class="clearfix">
			<?php echo $form->textField($model,'email', array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('email'))); ?><?php echo CHtml::submitButton('Check Email' ,array('onclick' => 'setEnableSave()')); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>
		
		<?php } else {
			$model->email = $_GET['email'];
			echo $form->hiddenField($model,'email');
		?>
		<div class="clearfix">
			<?php echo $form->passwordField($model,'password', array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('password'))); ?><?php echo CHtml::submitButton('Login' ,array('onclick' => 'setEnableSave()')); ?>
			<?php echo $form->error($model,'password'); ?>
		</div>
		<?php }?>
		
	</fieldset>

<?php $this->endWidget(); ?>
<?php //end.Content ?>