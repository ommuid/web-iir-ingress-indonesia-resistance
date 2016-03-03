<?php
/**
 * @var $this SiteController
 * @var $model Users
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Users'=>array('manage'),
		'Create',
	);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<div class="dialog-content">
	<?php if(!isset($_GET['type']) || (isset($_GET['type']) && $_GET['type'] != 'success')) {?>
		<fieldset>

			<?php echo $form->errorSummary($model); ?>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('old_password')?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->passwordField($model,'old_password',array('maxlength'=>32,'class'=>'span-7')); ?>
					<?php echo $form->error($model,'old_password'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('new_password')?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->passwordField($model,'new_password',array('maxlength'=>32,'class'=>'span-7')); ?>
					<?php echo $form->error($model,'new_password'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('confirm_password')?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->passwordField($model,'confirm_password',array('maxlength'=>32,'class'=>'span-7')); ?>
					<?php echo $form->error($model,'confirm_password'); ?>
				</div>
			</div>

		</fieldset>
	<?php } else {?>
		<div class="empty">
			<?php echo Phrase::trans(16121,1);?>
		</div>
	<?php }?>
</div>
<div class="dialog-submit">
	<?php if(!isset($_GET['type']) || (isset($_GET['type']) && $_GET['type'] != 'success')) {
		echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0) ,array('onclick' => 'setEnableSave()'));
	}?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>
