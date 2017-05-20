<?php
/**
 * Users (users)
 * @var $this AdminController
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
		$model->user_id=>array('view','id'=>$model->user_id),
		'Photo',
	);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		'on_post' => '',
	),
)); ?>
<div class="dialog-content">
	<fieldset>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'photos'); ?>
			<div class="desc">
				<?php 
				if(!$model->getErrors())
					$model->old_photos_i = $model->photos;
				if(!$model->isNewRecord && $model->old_photos_i != '') {
					echo $form->hiddenField($model,'old_photos_i');
					$photo = Yii::app()->request->baseUrl.'/public/users/'.$model->user_id.'/'.$model->old_photos_i;?>
						<img class="mb-10" src="<?php echo Utility::getTimThumb($photo, 300, 300, 3);?>" alt="">
				<?php }?>
				<?php echo $form->fileField($model,'photos'); ?>
				<?php echo $form->error($model,'photos'); ?>
				<span class="small-px">extensions are allowed: <?php echo Utility::formatFileType($photo_exts, false);?></span>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton(Yii::t('phrase', 'Upload'), array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>


