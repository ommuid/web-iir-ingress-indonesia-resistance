<?php
/**
 * OmmuMeta (ommu-meta)
 * @var $this MetaController
 * @var $model OmmuMeta
 * @var $form CActiveForm
 * version: 1.1.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Metas'=>array('manage'),
		$model->id=>array('view','id'=>$model->id),
		'Update',
	);

	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$('select#OmmuMeta_facebook_type').live('change', function() {
		var id = $(this).val();
		$('div.filter').slideUp();
		if(id == '1') {
			$('div.filter#profile').slideDown();
		}
	});
EOP;
	$cs->registerScript('type', $js, CClientScript::POS_END);
?>

<div class="form" name="post-on">

	<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
		'id'=>'ommu-meta-form',
		'enableAjaxValidation'=>true,
		//'htmlOptions' => array('enctype' => 'multipart/form-data')
	)); ?>

	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php echo $form->errorSummary($model); ?>
	</div>
	<?php //begin.Messages ?>

	<fieldset>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('facebook_on');?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->radioButtonList($model,'facebook_on', array(
					1 => Yii::t('phrase', 'Enabled'),
					0 => Yii::t('phrase', 'Disabled'),
				)); ?>
				<?php echo $form->error($model,'facebook_on'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('facebook_type');?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->dropDownList($model,'facebook_type', array(
					1 => Yii::t('phrase', 'Profile'),
					2 => Yii::t('phrase', 'Website'),
				)); ?>
				<?php echo $form->error($model,'facebook_type'); ?>
			</div>
		</div>
		
		<div id="profile" class="filter <?php echo $model->facebook_type != 1 ? 'hide' : '';?>">
			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('facebook_profile_firstname');?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->textField($model,'facebook_profile_firstname',array('maxlength'=>32,'class'=>'span-4')); ?>
					<?php echo $form->error($model,'facebook_profile_firstname'); ?>
					<span class="small-px silent"><?php echo Yii::t('phrase', 'The first name of the person that this profile represents');?></span>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('facebook_profile_lastname');?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->textField($model,'facebook_profile_lastname',array('maxlength'=>32,'class'=>'span-4')); ?>
					<?php echo $form->error($model,'facebook_profile_lastname'); ?>
					<span class="small-px silent"><?php echo Yii::t('phrase', 'The last name of the person that this profile represents');?></span>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('facebook_profile_username');?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->textField($model,'facebook_profile_username',array('maxlength'=>32,'class'=>'span-4')); ?>
					<?php echo $form->error($model,'facebook_profile_username'); ?>
					<span class="small-px silent"><?php echo Yii::t('phrase', 'A username for the person that this profile represents (.i.e. "PutraSudaryanto")');?></span>
				</div>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'facebook_sitename'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'facebook_sitename',array('maxlength'=>64,'class'=>'span-5')); ?>
				<?php echo $form->error($model,'facebook_sitename'); ?>
				<span class="small-px silent"><?php echo Yii::t('phrase', 'The name of the web site upon which the object resides (.i.e. "Ommu Platform & Bootstrap")');?></span>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'facebook_see_also'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'facebook_see_also',array('maxlength'=>256,'class'=>'span-5')); ?>
				<?php echo $form->error($model,'facebook_see_also'); ?>
				<span class="small-px silent"><?php echo Yii::t('phrase', 'URLs of related resources (.i.e. "http://www.ommu.co")');?></span>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'facebook_admins'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'facebook_admins',array('maxlength'=>32,'class'=>'span-4')); ?>
				<?php echo $form->error($model,'facebook_admins'); ?>
				<span class="small-px silent"><?php echo Yii::t('phrase', 'Facebook IDs of the app\'s administrators (.i.e. "PutraSudaryanto")');?></span>
			</div>
		</div>

		<div class="submit clearfix">
			<label>&nbsp;</label>
			<div class="desc">
				<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>

	</fieldset>
	<?php $this->endWidget(); ?>

</div>
