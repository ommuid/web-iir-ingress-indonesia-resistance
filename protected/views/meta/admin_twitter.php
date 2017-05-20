<?php
/**
 * OmmuMeta (ommu-meta)
 * @var $this MetaController
 * @var $model OmmuMeta
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
		'Ommu Metas'=>array('manage'),
		$model->id=>array('view','id'=>$model->id),
		'Update',
	);

	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$('select#OmmuMeta_twitter_card').on('change', function() {
		var id = $(this).val();
		$('div.filter').slideUp();
		if(id == '3') {
			$('div.filter#photo').slideDown();
		} else if(id == '4') {
			$('div.filter#application').slideDown();
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
			<label><?php echo $model->getAttributeLabel('twitter_on');?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->radioButtonList($model,'twitter_on', array(
					1 => Yii::t('phrase', 'Enabled'),
					0 => Yii::t('phrase', 'Disabled'),
				)); ?>
				<?php echo $form->error($model,'twitter_on'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('twitter_card');?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->dropDownList($model,'twitter_card', array(
					1 => Yii::t('phrase', 'Summary Card'),
					2 => Yii::t('phrase', 'Summary Card with Large Image'),
					3 => Yii::t('phrase', 'Photo Card'),
					4 => Yii::t('phrase', 'App Card'),
					//5 => Yii::t('phrase', 'Gallery Card'),
					//6 => Yii::t('phrase', 'Player Card'),
					//7 => Yii::t('phrase', 'Player Card: Approval Guide'),
					//8 => Yii::t('phrase', 'Product Card'),
				)); ?>
				<?php echo $form->error($model,'twitter_card'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('twitter_site');?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->textField($model,'twitter_site',array('maxlength'=>32,'class'=>'span-5')); ?>
				<?php echo $form->error($model,'twitter_site'); ?>
				<span class="small-px silent"><?php echo Yii::t('phrase', 'Your official site in twitter (.i.e. "@CareerCenterCodes, @OmmuPlatform")');?></span>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('twitter_creator');?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->textField($model,'twitter_creator',array('maxlength'=>32,'class'=>'span-5')); ?>
				<?php echo $form->error($model,'twitter_creator'); ?>
				<span class="small-px silent"><?php echo Yii::t('phrase', 'Creator your site in twitter (.i.e. "@PutraSudaryanto, @Mba_Em")');?></span>
			</div>
		</div>

		<div id="photo" class="filter <?php echo $model->twitter_card != 3 ? 'hide' : '';?>">
			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('twitter_photo_width');?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->textField($model,'twitter_photo_width',array('maxlength'=>3,'class'=>'span-3')); ?>
					<?php echo $form->error($model,'twitter_photo_width'); ?>
					<span class="small-px silent"><?php echo Yii::t('phrase', 'Providing width in px helps us more accurately preserve the aspect ratio of the image when resizing');?></span>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('twitter_photo_height');?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->textField($model,'twitter_photo_height',array('maxlength'=>3,'class'=>'span-3')); ?>
					<?php echo $form->error($model,'twitter_photo_height'); ?>
					<span class="small-px silent"><?php echo Yii::t('phrase', 'Providing height in px helps us more accurately preserve the aspect ratio of the image when resizing');?></span>
				</div>
			</div>
		</div>

		<div id="application" class="filter <?php echo $model->twitter_card != 4 ? 'hide' : '';?>">
			<div class="clearfix">
				<?php echo $form->labelEx($model,'twitter_country'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'twitter_country',array('maxlength'=>32,'class'=>'span-4')); ?>
					<?php echo $form->error($model,'twitter_country'); ?>
					<span class="small-px silent"><?php echo Yii::t('phrase', 'If your application is not available in the US App Store, you must set this value to the two-letter country code for the App Store that contains your application.');?></span>
				</div>
			</div>
			
			<div class="clearfix">
				<?php echo $form->labelEx($model,'twitter_iphone_name'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'twitter_iphone_name',array('maxlength'=>32,'class'=>'span-4')); ?>
					<?php echo $form->error($model,'twitter_iphone_name'); ?>
					<span class="small-px silent"><?php echo Yii::t('phrase', 'Name of your iPhone app');?></span>
				</div>
			</div>
			
			<div class="clearfix">
				<?php echo $form->labelEx($model,'twitter_iphone_id'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'twitter_iphone_id',array('maxlength'=>32,'class'=>'span-4')); ?>
					<?php echo $form->error($model,'twitter_iphone_id'); ?>
					<span class="small-px silent"><?php echo Yii::t('phrase', 'String value, and should be the numeric representation of your app ID in the App Store (.i.e. "307234931")');?></span>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'twitter_iphone_url'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'twitter_iphone_url',array('class'=>'span-7')); ?>
					<?php echo $form->error($model,'twitter_iphone_url'); ?>
					<span class="small-px silent"><?php echo Yii::t('phrase', 'Your app\'s custom URL scheme (you must include "://" after your scheme name)');?></span>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'twitter_ipad_name'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'twitter_ipad_name',array('maxlength'=>32,'class'=>'span-4')); ?>
					<?php echo $form->error($model,'twitter_ipad_name'); ?>
					<span class="small-px silent"><?php echo Yii::t('phrase', 'Name of your iPad optimized app');?></span>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'twitter_ipad_id'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'twitter_ipad_id',array('maxlength'=>32,'class'=>'span-4')); ?>
					<?php echo $form->error($model,'twitter_ipad_id'); ?>
					<span class="small-px silent"><?php echo Yii::t('phrase', 'String value, should be the numeric representation of your app ID in the App Store (.i.e. “307234931”)');?></span>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'twitter_ipad_url'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'twitter_ipad_url',array('class'=>'span-7')); ?>
					<?php echo $form->error($model,'twitter_ipad_url'); ?>
					<span class="small-px silent"><?php echo Yii::t('phrase', 'Your app\'s custom URL scheme (you must include "://" after your scheme name)');?></span>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'twitter_googleplay_name'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'twitter_googleplay_name',array('maxlength'=>32,'class'=>'span-4')); ?>
					<?php echo $form->error($model,'twitter_googleplay_name'); ?>
					<span class="small-px silent"><?php echo Yii::t('phrase', 'Name of your Android app');?></span>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'twitter_googleplay_id'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'twitter_googleplay_id',array('maxlength'=>32,'class'=>'span-4')); ?>
					<?php echo $form->error($model,'twitter_googleplay_id'); ?>
					<span class="small-px silent"><?php echo Yii::t('phrase', 'String value, and should be the numeric representation of your app ID in Google Play (.i.e. "co.ommu.nirwasita")');?></span>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'twitter_googleplay_url'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'twitter_googleplay_url',array('class'=>'span-7')); ?>
					<?php echo $form->error($model,'twitter_googleplay_url'); ?>
					<span class="small-px silent"><?php echo Yii::t('phrase', 'Your app\'s custom URL scheme (.i.e. "http://play.google.com/store/apps/details?id=co.ommu.nirwasita")');?></span>
				</div>
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
