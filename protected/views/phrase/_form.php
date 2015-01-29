<?php
/**
 * @var $this PhraseController
 * @var $model OmmuPhrases
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
	'id'=>'ommu-phrases-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<div class="dialog-content">

	<fieldset>

		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages ?>	
		
		<?php if($model->isNewRecord) {?>
		<div class="clearfix">
			<?php echo $form->labelEx($model,'plugin_id'); ?>
			<div class="desc">
				<?php echo $form->dropDownList($model,'plugin_id', OmmuPlugins::getPluginArray('id')); ?>
				<?php echo $form->error($model,'plugin_id'); ?>
			</div>
		</div>
		<?php }?>

		<?php foreach($language as $val) {?>
		<div class="clearfix">
			<?php echo CHtml::label($val->name, 'OmmuPhrases_'.$val->code); ?>
			<div class="desc">
				<?php 
				//echo $form->textArea($model,$val->code,array('rows'=>6, 'cols'=>50, 'class'=>'span-11 smaller'));
				$this->widget('application.extensions.cleditor.ECLEditor', array(
					'model'=>$model,
					'attribute'=>$val->code,
					'options'=>array(
						'width'=>'100%',
						'height'=>150,
						'useCSS'=>true,
						'controls'=>'bold italic underline strikethrough subscript superscript | bullets numbering | outdent indent | alignleft center alignright justify | undo redo | rule image link unlink | cut copy paste pastetext | print source',
					),
				)); ?>
				<?php echo $form->error($model, $val->code); ?>
			</div>
		</div>
		<?php }?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'location'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'location',array('class'=>'span-11 smaller')); ?>
				<?php echo $form->error($model,'location'); ?>
				<span class="small-px"><?php echo Phrase::trans(299,0);?></span>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>