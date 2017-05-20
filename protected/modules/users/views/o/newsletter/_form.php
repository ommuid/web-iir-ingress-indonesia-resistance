<?php
/**
 * User Newsletter (user-newsletter)
 * @var $this NewsletterController
 * @var $model UserNewsletter
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
    <?php echo CHtml::submitButton(Yii::t('phrase', 'Subscribe'), array('onclick' => 'setEnableSave()')); ?>
    <?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>

<?php $this->endWidget(); ?>
