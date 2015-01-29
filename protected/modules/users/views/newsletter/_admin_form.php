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
<div class="dialog-content">
	<fieldset>
		<?php $model->unsubscribe = 0;
		echo $form->hiddenField($model,'unsubscribe');?>
		
		<div class="clearfix">
			<?php echo $form->labelEx($model,'email'); ?>
			<div class="desc">
                <?php echo $form->textField($model,'email',array('maxlength'=>32, 'class'=>'span-9')); ?>
                <?php echo $form->error($model,'email'); ?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
    <?php echo CHtml::submitButton(Phrase::trans(23057,1), array('onclick' => 'setEnableSave()')); ?>
    <?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>

<?php $this->endWidget(); ?>
