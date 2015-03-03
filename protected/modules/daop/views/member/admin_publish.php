<?php
/**
 * Daop Users (daop-users)
 * @var $this MemberController * @var $model DaopUsers * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Daop Users'=>array('manage'),
		'Publish',
	);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'daop-users-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<div class="dialog-content">
		<?php echo $model->publish == 1 ? Phrase::trans(282,0) : Phrase::trans(281,0)?>
		<?php //echo $model->actived == 1 ? Phrase::trans(280,0) : Phrase::trans(279,0)?>
		<?php //echo $model->enabled == 1 ? Phrase::trans(286,0) : Phrase::trans(285,0)?>
		<?php //echo $model->status == 1 ? Phrase::trans(294,0) : Phrase::trans(293,0)?>
	</div>
	<div class="dialog-submit">
		<?php echo CHtml::submitButton($title, array('onclick' => 'setEnableSave()')); ?>
		<?php echo CHtml::button(Phrase::trans(174,0), array('id'=>'closed')); ?>
	</div>
	
<?php $this->endWidget(); ?>
