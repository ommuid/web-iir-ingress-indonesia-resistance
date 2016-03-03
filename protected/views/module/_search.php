<?php
/**
 * @var $this ModuleController
 * @var $model OmmuPlugins
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
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('plugin_id'); ?><br/>
			<?php echo $form->textField($model,'plugin_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('actived'); ?><br/>
			<?php echo $form->textField($model,'actived'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('orders'); ?><br/>
			<?php echo $form->textField($model,'orders'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('folder'); ?><br/>
			<?php echo $form->textField($model,'folder',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('code'); ?><br/>
			<?php echo $form->textField($model,'code'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('name'); ?><br/>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>128)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('desc'); ?><br/>
			<?php echo $form->textField($model,'desc',array('size'=>60,'maxlength'=>255)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('version'); ?><br/>
			<?php echo $form->textField($model,'version',array('size'=>16,'maxlength'=>16)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('icon'); ?><br/>
			<?php echo $form->textField($model,'icon',array('size'=>16,'maxlength'=>16)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_date'); ?><br/>
			<?php echo $form->textField($model,'creation_date'); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Phrase::trans(3,0)); ?>
		</li>
	</ul>
	<div class="clear"></div>
<?php $this->endWidget(); ?>
