<?php
/**
 * Banner Settings (banner-setting)
 * @var $this SettingController
 * @var $model BannerSetting
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Banner
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'banner-setting-form',
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
			<label>
				<?php echo $model->getAttributeLabel('license');?> <span class="required">*</span><br/>
				<span><?php echo Yii::t('phrase', 'Enter the your license key that is provided to you when you purchased this plugin. If you do not know your license key, please contact support team.');?></span>
			</label>
			<div class="desc">
				<?php 
				if($model->isNewRecord || (!$model->isNewRecord && $model->license == ''))
					$model->license = BannerSetting::getLicense();
			
				if($model->isNewRecord || (!$model->isNewRecord && $model->license == ''))
					echo $form->textField($model,'license',array('maxlength'=>32,'class'=>'span-4'));
				else
					echo $form->textField($model,'license',array('maxlength'=>32,'class'=>'span-4','disabled'=>'disabled'));?>
				<?php echo $form->error($model,'license'); ?>
				<span class="small-px"><?php echo Yii::t('phrase', 'Format: XXXX-XXXX-XXXX-XXXX');?></span>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'permission'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Yii::t('phrase', 'Select whether or not you want to let the public (visitors that are not logged-in) to view the following sections of your social network. In some cases (such as Profiles, Blogs, and Albums), if you have given them the option, your users will be able to make their pages private even though you have made them publically viewable here. For more permissions settings, please visit the General Settings page.');?></span>
				<?php echo $form->radioButtonList($model, 'permission', array(
					1 => Yii::t('phrase', 'Yes, the public can view banner unless they are made private.'),
					0 => Yii::t('phrase', 'No, the public cannot view banner.'),
				)); ?>
				<?php echo $form->error($model,'permission'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'meta_keyword'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'meta_keyword',array('rows'=>6, 'cols'=>50, 'class'=>'span-7 smaller')); ?>
				<?php echo $form->error($model,'meta_keyword'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'meta_description'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'meta_description',array('rows'=>6, 'cols'=>50, 'class'=>'span-7 smaller')); ?>
				<?php echo $form->error($model,'meta_description'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'banner_validation'); ?>
			<div class="desc">
				<?php echo $form->radioButtonList($model, 'banner_validation', array(
					1 => 'Yes, validation banner size before upload.',
					0 => 'No, not validation banner size before upload.',
				)); ?>
				<?php echo $form->error($model,'banner_validation'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'banner_resize'); ?>
			<div class="desc">
				<?php echo $form->radioButtonList($model, 'banner_resize', array(
					1 => 'Yes, resize banner after upload.',
					0 => 'No, not resize banner after upload.',
				)); ?>
				<?php echo $form->error($model,'banner_resize'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'banner_file_type'); ?>
			<div class="desc">
				<?php				
				if(!$model->getErrors()) {
					$banner_file_type = unserialize($model->banner_file_type);
					if(!empty($banner_file_type))
						$model->banner_file_type = Utility::formatFileType($banner_file_type, false);
				}
				echo $form->textField($model,'banner_file_type', array('class'=>'span-6')); ?>
				<?php echo $form->error($model,'banner_file_type'); ?>
				<span class="small-px">pisahkan jenis file dengan koma (,). example: "jpg, png, bmp"</span>
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


