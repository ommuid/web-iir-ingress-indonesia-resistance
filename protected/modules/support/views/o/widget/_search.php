<?php
/**
 * Support Widgets (support-widget)
 * @var $this WidgetController
 * @var $model SupportWidget
 * @var $form CActiveForm
 * version: 0.2.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 3 February 2016, 12:26 WIB
 * @link https://github.com/ommu/Support
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('widget_id'); ?><br/>
			<?php echo $form->textField($model,'widget_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publish'); ?><br/>
			<?php echo $form->textField($model,'publish'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('cat_id'); ?><br/>
			<?php echo $form->textField($model,'cat_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('widget_source'); ?><br/>
			<?php echo $form->textArea($model,'widget_source',array('rows'=>6, 'cols'=>50)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_date'); ?><br/>
			<?php echo $form->textField($model,'creation_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_id'); ?><br/>
			<?php echo $form->textField($model,'creation_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_date'); ?><br/>
			<?php echo $form->textField($model,'modified_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_id'); ?><br/>
			<?php echo $form->textField($model,'modified_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
