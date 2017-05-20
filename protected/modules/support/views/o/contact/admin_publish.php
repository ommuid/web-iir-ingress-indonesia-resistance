<?php
/**
 * Support Contacts (support-contacts)
 * @var $this ContactsController
 * @var $model SupportContacts
 * @var $form CActiveForm
 * version: 0.2.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Support
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Support Contacts'=>array('manage'),
		'Publish',
	);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'ommu-pages-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
	<div class="dialog-content">
		<?php echo $model->publish == 1 ? Yii::t('phrase', 'Are you sure you want to unpublish this item?') : Yii::t('phrase', 'Are you sure you want to publish this item?')?>
	</div>
	<div class="dialog-submit">
		<?php echo CHtml::submitButton($title, array('onclick' => 'setEnableSave()')); ?>
		<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
	</div>
<?php $this->endWidget(); ?>