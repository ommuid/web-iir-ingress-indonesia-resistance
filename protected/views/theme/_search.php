<?php
/**
 * @var $this ThemeController
 * @var $model OmmuThemes
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
			<?php echo $model->getAttributeLabel('theme_id'); ?><br/>
			<?php echo $form->textField($model,'theme_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('group_page'); ?><br/>
			<?php echo $form->textField($model,'group_page',array('size'=>6,'maxlength'=>6)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('default_theme'); ?><br/>
			<?php echo $form->textField($model,'default_theme'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('folder'); ?><br/>
			<?php echo $form->textField($model,'folder',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('layout'); ?><br/>
			<?php echo $form->textField($model,'layout',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('name'); ?><br/>
			<?php echo $form->textField($model,'name',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('thumbnail'); ?><br/>
			<?php echo $form->textField($model,'thumbnail',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Phrase::trans(3,0)); ?>
		</li>
	</ul>
	<div class="clear"></div>
<?php $this->endWidget(); ?>
