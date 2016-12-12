<?php
/**
 * User Verify (user-verify)
 * @var $this VerifyController
 * @var $model UserVerify
 * version: 1.1.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contact (+62)856-299-4114
 *
 */
 
	$this->breadcrumbs=array(
		'User Verifies'=>array('manage'),
		'Create',
	);

if(!isset($_GET['name']) && !isset($_GET['email'])) {?>
	<div class="boxed" name="post-on">
		<?php $form=$this->beginWidget('application.components.system.OActiveForm', array( 
			'id'=>'support-newsletter-form', 
			'enableAjaxValidation'=>true, 
			//'htmlOptions' => array('enctype' => 'multipart/form-data') 
		)); ?>
			<fieldset>
				<div class="clearfix">
					<?php 
					$model->unsubscribe = 0;
					echo $form->hiddenField($model,'unsubscribe');
					?>
					<div class="table">
						<?php echo $form->textField($model,'email',array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('email'))); ?><?php echo CHtml::submitButton($launch != 0 ? Yii::t('phrase', 'Notify Me!') : Yii::t('phrase', 'Subscribe'), array('onclick' => 'setEnableSave()')); ?>
					</div>
					<?php echo $form->error($model,'email'); ?>
				</div>

			</fieldset>
		<?php $this->endWidget();?>	
	</div>

<?php } else {?>
	
<?php }?>