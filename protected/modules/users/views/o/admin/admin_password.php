<?php
/**
 * Users (users)
 * @var $this SiteController
 * @var $model Users
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Users
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
				<label><?php echo $model->getAttributeLabel('oldPassword')?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->passwordField($model,'oldPassword',array('maxlength'=>32,'class'=>'span-7')); ?>
					<?php echo $form->error($model,'oldPassword'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('newPassword')?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->passwordField($model,'newPassword',array('maxlength'=>32,'class'=>'span-7')); ?>
					<?php echo $form->error($model,'newPassword'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('confirmPassword')?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->passwordField($model,'confirmPassword',array('maxlength'=>32,'class'=>'span-7')); ?>
					<?php echo $form->error($model,'confirmPassword'); ?>
				</div>
			</div>

		</fieldset>
	<?php } else {?>
		<div class="empty">
			<?php echo Yii::t('phrase', 'Change password success.');?>
		</div>
	<?php }?>
</div>
<div class="dialog-submit">
	<?php if(!isset($_GET['type']) || (isset($_GET['type']) && $_GET['type'] != 'success')) {
		echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()'));
	}?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>
