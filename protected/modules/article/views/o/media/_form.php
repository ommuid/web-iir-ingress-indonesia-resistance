<?php
/**
 * ArticleMedia (article-media)
 * @var $this MediaController
 * @var $model ArticleMedia
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Articles
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
			<?php echo $form->labelEx($model,'old_media'); ?>
			<div class="desc">
				<?php 
				$model->old_media = $model->media;
				echo $form->hiddenField($model,'old_media');
				if(in_array($model->article->article_type, array(1,3))) {
					$media = Yii::app()->request->baseUrl.'/public/article/'.$model->article_id.'/'.$model->old_media;
				}
				if($model->article->article_type == 1) {?>
					<img src="<?php echo Utility::getTimThumb($media, 400, 400, 3);?>" alt="">
				<?php } else if($model->article->article_type == 2) {?>
					<iframe width="320" height="200" src="//www.youtube.com/embed/<?php echo $model->old_media;?>" frameborder="0" allowfullscreen></iframe>
				<?php } else if($model->article->article_type == 3) {?>
					<audio src="<?php echo $media?>" controls="true" loop="true" autoplay="false"></audio>
				<?php }?>
			</div>
		</div>
		<?php }?>

		<?php if($model->article->article_type == 1) {?>
			<div class="clearfix">
				<?php echo $form->labelEx($model,'media'); ?>
				<div class="desc">
					<?php echo $form->fileField($model,'media',array('maxlength'=>64)); ?>
					<?php echo $form->error($model,'media'); ?>
				</div>
			</div>
			
		<?php }
			if($model->article->article_type == 2) {
		?>
			<div class="clearfix">
				<?php echo $form->labelEx($model,'video'); ?>
				<div class="desc">
					<?php
					$model->video = $model->media;
					echo $form->textField($model,'video',array('maxlength'=>32)); ?>
					<?php echo $form->error($model,'video'); ?>
					<span class="small-px">http://www.youtube.com/watch?v=<strong>HOAqSoDZSho</strong></span>
				</div>
			</div>		
			
		<?php }
			if($model->article->article_type == 3) {
		?>
			<div class="clearfix">
				<?php echo $form->labelEx($model,'audio'); ?>
				<div class="desc">
					<?php echo $form->fileField($model,'audio',array('maxlength'=>64)); ?>
					<?php echo $form->error($model,'audio'); ?>
				</div>
			</div>
		<?php }?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'caption'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'caption',array('rows'=>6, 'cols'=>50)); ?>
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
