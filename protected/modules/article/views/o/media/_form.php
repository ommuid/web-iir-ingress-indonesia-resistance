<?php
/**
 * ArticleMedia (article-media)
 * @var $this MediaController
 * @var $model ArticleMedia
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/mod-article
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'article-media-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php
		echo $form->errorSummary($model);
		if(Yii::app()->user->hasFlash('error'))
			echo Utility::flashError(Yii::app()->user->getFlash('error'));
		if(Yii::app()->user->hasFlash('success'))
			echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
		?>
	</div>
	<?php //begin.Messages ?>

	<fieldset>
	
		<?php if(!$model->isNewRecord) {?>		
		<div class="clearfix">
			<?php echo $form->labelEx($model,'old_media_input'); ?>
			<div class="desc">
				<?php 
				if(!$model->getErrors())
					$model->old_media_input = $model->media;
				echo $form->hiddenField($model,'old_media_input');
				if($model->article->article_type == 'standard') {
					$media = Yii::app()->request->baseUrl.'/public/article/'.$model->article_id.'/'.$model->old_media_input;?>
					<img src="<?php echo Utility::getTimThumb($media, 400, 400, 3);?>" alt="">
				<?php } else if($model->article->article_type == 'video') {?>
					<iframe width="320" height="200" src="//www.youtube.com/embed/<?php echo $model->old_media_input;?>" frameborder="0" allowfullscreen></iframe>
				<?php }?>
			</div>
		</div>
		<?php }?>

		<?php if($model->article->article_type == 'standard') {?>
			<div class="clearfix">
				<?php echo $form->labelEx($model,'media'); ?>
				<div class="desc">
					<?php echo $form->fileField($model,'media',array('maxlength'=>64)); ?>
					<?php echo $form->error($model,'media'); ?>
					<span class="small-px">extensions are allowed: <?php echo Utility::formatFileType($media_file_type, false);?></span>
				</div>
			</div>
			
		<?php }
			if($model->article->article_type == 'video') {?>
			<div class="clearfix">
				<?php echo $form->labelEx($model,'video_input'); ?>
				<div class="desc">
					<?php
					if(!$model->getErrors())
						$model->video_input = $model->media;
					echo $form->textField($model,'video_input',array('maxlength'=>32)); ?>
					<?php echo $form->error($model,'video_input'); ?>
					<span class="small-px">http://www.youtube.com/watch?v=<strong>HOAqSoDZSho</strong></span>
				</div>
			</div>			
		<?php }?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'caption'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'caption',array('rows'=>6, 'cols'=>50, 'class'=>'span-10 smaller')); ?>
				<?php echo $form->error($model,'caption'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'cover'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'cover'); ?>
				<?php echo $form->error($model,'cover'); ?>
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
