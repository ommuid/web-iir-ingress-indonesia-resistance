<?php
/**
 * Ommu Plugins (ommu-plugins)
 * @var $this AdminController
 * @var $model OmmuPlugins
 * @var $form CActiveForm
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Plugins'=>array('manage'),
		'Install',
	);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'projects-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
	<div class="dialog-content">
		<?php echo Yii::t('phrase', 'Are you sure you want install this module?');?>
	</div>
	<div class="dialog-submit">
		<?php echo CHtml::submitButton(Yii::t('phrase', 'Install'), array('onclick' => 'setEnableSave()')); ?>
		<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
	</div>
<?php $this->endWidget(); ?>