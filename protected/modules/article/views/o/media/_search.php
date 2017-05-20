<?php
/**
 * ArticleMedia (article-media)
 * @var $this MediaController
 * @var $model ArticleMedia
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Articles
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
			<?php echo $model->getAttributeLabel('media_id'); ?><br/>
			<?php echo $form->textField($model,'media_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('article_id'); ?><br/>
			<?php echo $form->textField($model,'article_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('cover'); ?><br/>
			<?php echo $form->textField($model,'cover'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('media'); ?><br/>
			<?php echo $form->textField($model,'media',array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_date'); ?><br/>
			<?php echo $form->textField($model,'creation_date'); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
	<div class="clear"></div>
<?php $this->endWidget(); ?>
