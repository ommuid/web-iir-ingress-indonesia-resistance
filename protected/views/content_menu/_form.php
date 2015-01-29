<?php
/**
 * @var $this ContentmenuController
 * @var $model OmmuContentMenu
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
	'id'=>'ommu-content-menu-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<div class="dialog-content">

	<fieldset>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'title'); ?>
			<div class="desc">
				<?php
				$model->title = Phrase::trans($model->name, 2);
				echo $form->textField($model,'title',array('maxlength'=>32,'class'=>'span-8')); ?>
				<?php echo $form->error($model,'title'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'params'); ?>
			<div class="desc clearfix">
				<?php echo $form->dropDownList($model,'module',OmmuPlugins::getPluginArray('name')); ?><br/>
				<?php echo $form->textField($model,'controller',array('maxlength'=>32,'class'=>'span-8 mb-5', 'placeholder'=>$model->getAttributeLabel('controller'))); ?><br/>
				<?php echo $form->textField($model,'action',array('maxlength'=>32,'class'=>'span-8', 'placeholder'=>$model->getAttributeLabel('action'))); ?>
				<?php echo $form->error($model,'params'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'icon'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'icon',array('maxlength'=>16,'class'=>'span-8')); ?>
				<?php echo $form->error($model,'icon'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'class'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'class',array('maxlength'=>16,'class'=>'span-8')); ?>
				<?php echo $form->error($model,'class'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'url'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'url',array('maxlength'=>128,'class'=>'span-8')); ?>
				<?php echo $form->error($model,'url'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'attr'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'attr',array('maxlength'=>128,'class'=>'span-8')); ?>
				<?php echo $form->error($model,'attr'); ?>
			</div>
		</div>

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'dialog'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'dialog'); ?>
				<?php echo $form->labelEx($model,'dialog'); ?>
				<?php echo $form->error($model,'dialog'); ?>
			</div>
		</div>

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'enabled'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'enabled'); ?>
				<?php echo $form->labelEx($model,'enabled'); ?>
				<?php echo $form->error($model,'enabled'); ?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>

