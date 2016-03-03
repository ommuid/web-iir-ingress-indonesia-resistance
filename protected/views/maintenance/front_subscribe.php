<?php
/**
 * @var $this VerifyController
 * @var $model UserVerify
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
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
						<?php echo $form->textField($model,'email',array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('email'))); ?><?php echo CHtml::submitButton($launch != 0 ? Phrase::trans(23109,1) : Phrase::trans(23057,1), array('onclick' => 'setEnableSave()')); ?>
					</div>
					<?php echo $form->error($model,'email'); ?>
				</div>

			</fieldset>
		<?php $this->endWidget();?>	
	</div>

<?php } else {?>
	
<?php }?>