<?php
/**
 * Banner Clicks (banner-clicks)
 * @var $this ClickController
 * @var $model BannerClicks
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 8 January 2017, 20:54 WIB
 * @link https://github.com/ommu/Banner
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
			<?php echo $model->getAttributeLabel('click_id'); ?><br/>
			<?php echo $form->textField($model,'click_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('banner_id'); ?><br/>
			<?php echo $form->textField($model,'banner_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('user_id'); ?><br/>
			<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('clicks'); ?><br/>
			<?php echo $form->textField($model,'clicks'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('click_date'); ?><br/>
			<?php echo $form->textField($model,'click_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('click_ip'); ?><br/>
			<?php echo $form->textField($model,'click_ip',array('size'=>20,'maxlength'=>20)); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
