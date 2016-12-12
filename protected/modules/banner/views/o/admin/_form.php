<?php
/**
 * Banners (banners)
 * @var $this AdminController
 * @var $model Banners
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Banner
 * @contect (+62)856-299-4114
 *
 */

	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$('#Banners_permanent').live('change', function() {
		var id = $(this).prop('checked');		
		if(id == true) {
			$('div#expired-date').slideUp();
		} else {
			$('div#expired-date').slideDown();
		}
	});
EOP;
	$cs->registerScript('expired', $js, CClientScript::POS_END);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'banners-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<?php //begin.Messages ?>
<div id="ajax-message">
	<?php echo $form->errorSummary($model); ?>
</div>
<?php //begin.Messages ?>

<fieldset>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'cat_id'); ?>
		<div class="desc">
			<?php 
			$category = BannerCategory::getCategory(1);
			if($category != null)
				echo $form->dropDownList($model,'cat_id', $category);
			else
				echo $form->dropDownList($model,'cat_id', array('prompt'=>'No Parent'));
			echo $form->error($model,'cat_id');?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'title'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'title',array('class'=>'span-7', 'maxlength'=>64)); ?>
			<?php echo $form->error($model,'title'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'url'); ?>
		<div class="desc">
			<?php echo $form->textArea($model,'url',array('class'=>'span-10 smaller', 'rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'url'); ?>
			<div class="small-px silent">example: http://opensource.ommu.co</div>
		</div>
	</div>
	
	<?php if(!$model->isNewRecord) {
		$model->old_media = $model->media;
		echo $form->hiddenField($model,'old_media');
		if($model->media != '') {
			$resizeSize = explode(',', $model->category_relation->media_size);
			$file = Yii::app()->request->baseUrl.'/public/banner/'.$model->old_media;
			$media = '<img src="'.Utility::getTimThumb($file, $resizeSize[0], $resizeSize[1], 1).'" alt="">';
			echo '<div class="clearfix">';
			echo $form->labelEx($model,'old_media');
			echo '<div class="desc">'.$media.'</div>';
			echo '</div>';
		}
	}?>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'media'); ?>
		<div class="desc">
			<?php echo $form->fileField($model,'media'); ?>
			<?php echo $form->error($model,'media'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'published_date'); ?>
		<div class="desc">
			<?php
			!$model->isNewRecord ? ($model->published_date != '0000-00-00' ? $model->published_date = date('d-m-Y', strtotime($model->published_date)) : '') : '';
			//echo $form->textField($model,'published_date');
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				'model'=>$model,
				'attribute'=>'published_date',
				//'mode'=>'datetime',
				'options'=>array(
					'dateFormat' => 'dd-mm-yy',
				),
				'htmlOptions'=>array(
					'class' => 'span-4',
				 ),
			)); ?>
			<?php echo $form->error($model,'published_date'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<?php 
	$model->permanent = 0;
	if($model->isNewRecord || (!$model->isNewRecord && in_array(date('Y-m-d', strtotime($model->expired_date)), array('0000-00-00','1970-01-01'))))
		$model->permanent = 1;
	?>
	
	<div class="clearfix">
		<?php echo $form->labelEx($model,'permanent'); ?>
		<div class="desc">
			<?php echo $form->checkBox($model,'permanent'); ?>
			<?php echo $form->error($model,'permanent'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>
	
	<div id="expired-date" class="clearfix <?php echo $model->permanent == 1 ? 'hide' : ''?>">
		<?php echo $form->labelEx($model,'expired_date'); ?>
		<div class="desc">
			<?php
			!$model->isNewRecord ? (!in_array(date('Y-m-d', strtotime($model->expired_date)), array('0000-00-00','1970-01-01')) ? $model->expired_date = date('d-m-Y', strtotime($model->expired_date)) : '') : '';
			//echo $form->textField($model,'expired_date');
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				'model'=>$model,
				'attribute'=>'expired_date',
				//'mode'=>'datetime',
				'options'=>array(
					'dateFormat' => 'dd-mm-yy',
				),
				'htmlOptions'=>array(
					'class' => 'span-4',
				 ),
			)); ?>
			<?php echo $form->error($model,'expired_date'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'publish'); ?>
		<div class="desc">
			<?php echo $form->checkBox($model,'publish'); ?>
			<?php echo $form->error($model,'publish'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
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


