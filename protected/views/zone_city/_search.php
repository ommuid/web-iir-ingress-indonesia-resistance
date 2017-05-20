<?php
/**
 * Ommu Zone Cities (ommu-zone-city)
 * @var $this ZonecityController
 * @var $model OmmuZoneCity
 * @var $form CActiveForm
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2015 Ommu Platform (opensource.ommu.co)
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
			<?php echo $model->getAttributeLabel('city_id'); ?><br/>
			<?php echo $form->textField($model,'city_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publish'); ?><br/>
			<?php echo $form->textField($model,'publish'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('province_id'); ?><br/>
			<?php echo $form->textField($model,'province_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('city_name'); ?><br/>
			<?php echo $form->textField($model,'city_name',array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('mfdonline'); ?><br/>
			<?php echo $form->textField($model,'mfdonline',array('size'=>4,'maxlength'=>4)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('checked'); ?><br/>
			<?php echo $form->textField($model,'checked'); ?>
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
