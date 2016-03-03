<?php
/**
 * @var $this VerifyController
 * @var $model UserVerify
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
    'id'=>'support-newsletter-form', 
    'enableAjaxValidation'=>true, 
    //'htmlOptions' => array('enctype' => 'multipart/form-data') 
)); ?>
	<fieldset>
		<div class="clearfix">
			<?php if($launch == 2)
				$model->unsubscribe = 1;
			else {
				$model->unsubscribe = 0;
			}
			echo $form->hiddenField($model,'unsubscribe');
			?>
			<?php echo $form->textField($model,'email',array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('email'), 'class'=>'span-9')); ?><?php echo CHtml::submitButton($launch == 0 ? Phrase::trans(23109,1) : ($launch == 1 ? Phrase::trans(23057,1) : Phrase::trans(23110,1)), array('onclick' => 'setEnableSave()')); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>

	</fieldset>
<?php $this->endWidget(); ?>
