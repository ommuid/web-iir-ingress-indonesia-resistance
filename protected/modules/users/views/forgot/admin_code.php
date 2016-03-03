<?php 
/**
 * @var $this ForgotController
 * @var $model UserForgot
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */
 
	$this->breadcrumbs=array(
		'User Forgots'=>array('manage'),
		'Create',
	);

if($render == 1) {
	echo '<a class="button" href="'.Yii::app()->createUrl('users/forgot/get').'" title="'.Phrase::trans(597,0).'">'.Phrase::trans(597,0).'</a>';
	
} else if($render == 2) {?>
	<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
		'action'=>Yii::app()->controller->createUrl('post', array('id'=>Yii::app()->params['reset_user_id'])),
		'id'=>'users-form',
		'enableAjaxValidation'=>true,
		'htmlOptions' => array(
			'class' => 'form',
			'enctype' => 'multipart/form-data',
		),
	)); ?>

		<fieldset>
			<div class="cell">
				<?php
				if($model->photo_id == 0) {
					$images = Yii::app()->request->baseUrl.'/public/users/default.png';
				} else {
					$images = Yii::app()->request->baseUrl.'/public/users/'.$model->user_id.'/'.$model->photo->photo;
				}?>
				<img src="<?php echo Utility::getTimThumb($images, 120, 120, 1);?>" alt="<?php echo $model->photo_id != 0 ? $model->displayname: 'Ommu Platform';?>"/>
			</div>
			<div class="cell">
				<div class="user-info">
					<strong><?php echo $model->displayname;?></strong>
					<?php echo $model->email;?>
				</div>
				<div class="clearfix">
					<div class="desc">
						<?php echo $form->passwordField($model,'new_password',array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('new_password'))); ?>
						<?php echo $form->error($model,'new_password'); ?>
					</div>
				</div>

				<div class="clearfix">
					<div class="desc">
						<?php echo $form->passwordField($model,'confirm_password',array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('confirm_password'))); ?>
						<?php echo $form->error($model,'confirm_password'); ?>
					</div>
				</div>

				<div class="submit clearfix">
					<div class="desc">
						<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0) ,array('onclick' => 'setEnableSave()', 'class'=>'blue-button')); ?>
					</div>
				</div>
			</div>
		</fieldset>

	<?php $this->endWidget(); ?>
<?php }?>
