<div name="post-on">
	<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
		'id'=>'ommu-walls-form',
		'enableAjaxValidation'=>true,
		//'htmlOptions' => array('enctype' => 'multipart/form-data')
	)); ?>
	<fieldset>
		<?php echo $form->textArea($model,'wall_status',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
	</fieldset>
	<?php $this->endWidget(); ?>
</div>