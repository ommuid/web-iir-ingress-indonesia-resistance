<?php
/**
 * @var $this ModuleController
 * @var $model OmmuPlugins
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Plugins'=>array('manage'),
		'Upload',
	);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'ommu-plugins-upload-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		'on_post' => '',
	)
)); ?>
<div class="dialog-content">

	<fieldset>

		<div class="clearfix">
			<label><?php echo Phrase::trans(505,0);?></label>
			<div class="desc">
				<?php echo CHtml::fileField('module_file', '',array('maxlength'=>128)); ?>
				<?php echo Yii::app()->user->hasFlash('error') ? '<div class="errorMessage">'.Yii::app()->user->getFlash('error').'</div>' : ''?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton(Phrase::trans(500,0), array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>
