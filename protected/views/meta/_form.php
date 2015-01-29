<?php
/**
 * @var $this MetaController
 * @var $model OmmuMeta
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */
?>

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
		<?php echo $form->labelEx($model,'id'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'id'); ?>
			<?php echo $form->error($model,'id'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'meta_image'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'meta_image',array('size'=>60,'maxlength'=>64)); ?>
			<?php echo $form->error($model,'meta_image'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'office_on'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'office_on'); ?>
			<?php echo $form->error($model,'office_on'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'office_location'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'office_location',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'office_location'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'office_place'); ?>
		<div class="desc">
			<?php echo $form->textArea($model,'office_place',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'office_place'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'office_country'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'office_country'); ?>
			<?php echo $form->error($model,'office_country'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'office_province'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'office_province'); ?>
			<?php echo $form->error($model,'office_province'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'office_city'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'office_city'); ?>
			<?php echo $form->error($model,'office_city'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'office_district'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'office_district'); ?>
			<?php echo $form->error($model,'office_district'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'office_village'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'office_village'); ?>
			<?php echo $form->error($model,'office_village'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'office_zipcode'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'office_zipcode',array('size'=>6,'maxlength'=>6)); ?>
			<?php echo $form->error($model,'office_zipcode'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'office_hour'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'office_hour',array('size'=>60,'maxlength'=>64)); ?>
			<?php echo $form->error($model,'office_hour'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'office_phone'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'office_phone',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'office_phone'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'office_fax'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'office_fax',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'office_fax'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'office_email'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'office_email',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'office_email'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'office_hotline'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'office_hotline',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'office_hotline'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'office_website'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'office_website',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'office_website'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'google_on'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'google_on'); ?>
			<?php echo $form->error($model,'google_on'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'twitter_on'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'twitter_on'); ?>
			<?php echo $form->error($model,'twitter_on'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'twitter_card'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'twitter_card'); ?>
			<?php echo $form->error($model,'twitter_card'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'twitter_site'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'twitter_site',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'twitter_site'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'twitter_creator'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'twitter_creator',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'twitter_creator'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'twitter_photo_width'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'twitter_photo_width',array('size'=>3,'maxlength'=>3)); ?>
			<?php echo $form->error($model,'twitter_photo_width'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'twitter_photo_height'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'twitter_photo_height',array('size'=>3,'maxlength'=>3)); ?>
			<?php echo $form->error($model,'twitter_photo_height'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'twitter_iphone_id'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'twitter_iphone_id',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'twitter_iphone_id'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'twitter_iphone_url'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'twitter_iphone_url',array('size'=>60,'maxlength'=>256)); ?>
			<?php echo $form->error($model,'twitter_iphone_url'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'twitter_ipad_name'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'twitter_ipad_name',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'twitter_ipad_name'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'twitter_ipad_url'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'twitter_ipad_url',array('size'=>60,'maxlength'=>256)); ?>
			<?php echo $form->error($model,'twitter_ipad_url'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'twitter_googleplay_id'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'twitter_googleplay_id',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'twitter_googleplay_id'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'twitter_googleplay_url'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'twitter_googleplay_url',array('size'=>60,'maxlength'=>256)); ?>
			<?php echo $form->error($model,'twitter_googleplay_url'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'facebook_on'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'facebook_on'); ?>
			<?php echo $form->error($model,'facebook_on'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'facebook_type'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'facebook_type'); ?>
			<?php echo $form->error($model,'facebook_type'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'facebook_profile_firstname'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'facebook_profile_firstname',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'facebook_profile_firstname'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'facebook_profile_lastname'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'facebook_profile_lastname',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'facebook_profile_lastname'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'facebook_profile_username'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'facebook_profile_username',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'facebook_profile_username'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'facebook_sitename'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'facebook_sitename',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'facebook_sitename'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'facebook_see_also'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'facebook_see_also',array('size'=>60,'maxlength'=>256)); ?>
			<?php echo $form->error($model,'facebook_see_also'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'facebook_admins'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'facebook_admins',array('size'=>32,'maxlength'=>32)); ?>
			<?php echo $form->error($model,'facebook_admins'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="submit clearfix">
		<label>&nbsp;</label>
		<div class="desc">
			<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
		</div>
	</div>

</fieldset>
<?php $this->endWidget(); ?>
