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

	$this->breadcrumbs=array(
		'Banner Clicks'=>array('manage'),
		'Delete',
	);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'banner-clicks-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<div class="dialog-content">
		<?php echo Yii::t('phrase', 'Are you sure you want to delete this item?');?>
	</div>
	<div class="dialog-submit">
		<?php echo CHtml::submitButton(Yii::t('phrase', 'Delete'), array('onclick' => 'setEnableSave()')); ?>
		<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
	</div>
	
<?php $this->endWidget(); ?>
