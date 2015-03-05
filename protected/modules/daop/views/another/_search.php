<?php
/**
 * Daop Anothers (daop-anothers)
 * @var $this AnotherController * @var $model DaopAnothers * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('another_id'); ?><br/>
			<?php echo $form->textField($model,'another_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('status'); ?><br/>
			<?php echo $form->textField($model,'status'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('another_name'); ?><br/>
			<?php echo $form->textField($model,'another_name',array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('another_desc'); ?><br/>
			<?php echo $form->textArea($model,'another_desc',array('rows'=>6, 'cols'=>50)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('another_cover'); ?><br/>
			<?php echo $form->textField($model,'another_cover',array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('another_photo'); ?><br/>
			<?php echo $form->textField($model,'another_photo',array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('country_id'); ?><br/>
			<?php echo $form->textField($model,'country_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('province_id'); ?><br/>
			<?php echo $form->textField($model,'province_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('city_id'); ?><br/>
			<?php echo $form->textField($model,'city_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('users'); ?><br/>
			<?php echo $form->textField($model,'users'); ?>
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
			<?php echo CHtml::submitButton(Phrase::trans(3,0)); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
