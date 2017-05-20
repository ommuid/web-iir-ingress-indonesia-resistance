<?php
/**
 * Article Download Details (article-download-detail)
 * @var $this DownloaddetailController
 * @var $model ArticleDownloadDetail
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 8 January 2017, 21:21 WIB
 * @link https://github.com/ommu/Articles
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
			<?php echo $model->getAttributeLabel('id'); ?><br/>
			<?php echo $form->textField($model,'id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('download_id'); ?><br/>
			<?php echo $form->textField($model,'download_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('download_date'); ?><br/>
			<?php echo $form->textField($model,'download_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('download_ip'); ?><br/>
			<?php echo $form->textField($model,'download_ip',array('size'=>20,'maxlength'=>20)); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
