<?php
/**
 * Ommu Options (ommu-options)
 * @var $this OptionController
 * @var $model OmmuOptions
 * @var $form CActiveForm
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 17 March 2017, 10:49 WIB
 * @link https://github.com/ommu/Core
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
			<?php echo $model->getAttributeLabel('option_id'); ?><br/>
			<?php echo $form->textField($model,'option_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('autoload'); ?><br/>
			<?php echo $form->textField($model,'autoload'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('option_type'); ?><br/>
			<?php echo $form->textField($model,'option_type',array('size'=>6,'maxlength'=>6)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('option_name'); ?><br/>
			<?php echo $form->textField($model,'option_name',array('size'=>60,'maxlength'=>128)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('option_value'); ?><br/>
			<?php echo $form->textArea($model,'option_value',array('rows'=>6, 'cols'=>50)); ?>
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
