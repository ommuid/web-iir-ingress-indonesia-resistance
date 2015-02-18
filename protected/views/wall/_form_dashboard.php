<div name="post-on">
	<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
		'id'=>'ommu-walls-form',
		'action'=>Yii::app()->createUrl('wall/post'),
		'enableAjaxValidation'=>true,
		//'htmlOptions' => array('enctype' => 'multipart/form-data')
	)); ?>
	<fieldset>
		<div>
			<?php echo $form->textArea($model,'wall_status',array('rows'=>6, 'cols'=>50, 'class'=>'span-11 smaller', 'placeholder'=>'Post your status..')); ?>
		</div>
		<div class="clearfix">
			<?php echo CHtml::submitButton('Share', array('onclick' => 'setEnableSave()')); ?>
			<?php echo $form->error($model,'wall_status'); ?>
		</div>
	</fieldset>
	<?php $this->endWidget(); ?>
</div>