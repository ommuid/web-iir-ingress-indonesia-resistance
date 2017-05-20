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

	$this->breadcrumbs=array(
		'Article Medias'=>array('manage'),
		'Cover',
	);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'article-media-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
	<div class="dialog-content">
		<?php echo Yii::t('phrase', 'Are you sure made ​​cover this item?');?>
	</div>
	<div class="dialog-submit">
		<?php echo CHtml::submitButton(Yii::t('phrase', 'Set Cover'), array('onclick' => 'setEnableSave()')); ?>
		<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
	</div>
<?php $this->endWidget(); ?>