<?php
/**
 * @var $this LevelController
 * @var $model UserLevel
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'User Levels'=>array('manage'),
		$model->name=>array('view','id'=>$model->level_id),
		'Update',
	);
?>

<div class="form" name="post-on">
	<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
		'id'=>'user-level-form',
		'enableAjaxValidation'=>true,
		//'htmlOptions' => array('enctype' => 'multipart/form-data')
	)); ?>

		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages ?>

		<h3><?php echo Phrase::trans(16019,1);?></h3>
		<fieldset>

			<div class="intro">
				<?php echo Phrase::trans(16020,1);?>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'profile_block'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Phrase::trans(16059,1);?></span>
					<?php echo $form->radioButtonList($model, 'profile_block', array(
						1 => Phrase::trans(16060,1),
						0 => Phrase::trans(16061,1),
					)); ?>
					<?php echo $form->error($model,'profile_block'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo Phrase::trans(16062,1);?></label>
				<div class="desc">
					<p><?php echo Phrase::trans(16063,1);?></p>
					<span class="desc"><?php echo Phrase::trans(16064,1);?></span>
					<?php echo $form->radioButtonList($model, 'profile_search', array(
						1 => Phrase::trans(16065,1),
						0 => Phrase::trans(16066,1),
					)); ?>
					<?php echo $form->error($model,'profile_search'); ?>

					<p><?php echo Phrase::trans(16067,1);?></p>
					<span class="desc"><?php echo Phrase::trans(16068,1);?></span>
					<?php echo $form->checkBoxList($model, 'profile_privacy', array(
						1 => Phrase::trans(16071,1),
						2 => Phrase::trans(16072,1),
						3 => Phrase::trans(16073,1),
						4 => Phrase::trans(16074,1),
						5 => Phrase::trans(16075,1),
						6 => Phrase::trans(16076,1),
					)); ?>
					<?php echo $form->error($model,'profile_privacy'); ?>

					<p><?php echo Phrase::trans(16069,1);?></p>
					<span class="desc"><?php echo Phrase::trans(16070,1);?></span>
					<?php echo $form->checkBoxList($model, 'profile_comments', array(
						1 => Phrase::trans(16071,1),
						2 => Phrase::trans(16072,1),
						3 => Phrase::trans(16073,1),
						4 => Phrase::trans(16074,1),
						5 => Phrase::trans(16075,1),
						6 => Phrase::trans(16076,1),
					)); ?>
					<?php echo $form->error($model,'profile_comments'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'photo_allow'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Phrase::trans(16022,1);?></span>
					<?php echo $form->radioButtonList($model, 'photo_allow', array(
						1 => Phrase::trans(16023,1),
						0 => Phrase::trans(16024,1),
					)); ?>
					<?php echo $form->error($model,'photo_allow'); ?>

					<span class="small-px"><?php echo Phrase::trans(16025,1);?></span>
					<?php echo Phrase::trans(16026,1);?>&nbsp;<?php echo $form->textField($model,'photo_width'); ?>&nbsp;<?php echo Phrase::trans(16028,1);?><br/>
					<?php echo $form->error($model,'photo_width'); ?>

					<?php echo Phrase::trans(16027,1);?>&nbsp;<?php echo $form->textField($model,'photo_height'); ?>&nbsp;<?php echo Phrase::trans(16028,1);?><br/>
					<?php echo $form->error($model,'photo_height'); ?>

					<span class="small-px"><?php echo Phrase::trans(16029,1);?></span>
					<?php echo Phrase::trans(16030,1);?>&nbsp;<?php echo $form->textField($model,'photo_exts',array('maxlength'=>32)); ?><br/>
					<?php echo $form->error($model,'photo_exts'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'profile_style'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Phrase::trans(16032,1);?></span>
					<?php echo $form->radioButtonList($model, 'profile_style', array(
						1 => Phrase::trans(16033,1),
						0 => Phrase::trans(16034,1),
					)); ?>
					<?php echo $form->error($model,'profile_style'); ?>

					<span class="small-px"><?php echo Phrase::trans(16035,1);?></span>
					<?php echo $form->radioButtonList($model, 'profile_style_sample', array(
						1 => Phrase::trans(16036,1),
						0 => Phrase::trans(16037,1),
					)); ?>
					<?php echo $form->error($model,'profile_style_sample'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'profile_status'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Phrase::trans(16039,1);?></span>
					<?php echo $form->radioButtonList($model, 'profile_status', array(
						1 => Phrase::trans(16040,1),
						0 => Phrase::trans(16041,1),
					)); ?>
					<?php echo $form->error($model,'profile_status'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'profile_invisible'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Phrase::trans(16043,1);?></span>
					<?php echo $form->radioButtonList($model, 'profile_invisible', array(
						1 => Phrase::trans(16044,1),
						0 => Phrase::trans(16045,1),
					)); ?>
					<?php echo $form->error($model,'profile_invisible'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'profile_views'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Phrase::trans(16047,1);?></span>
					<?php echo $form->radioButtonList($model, 'profile_views', array(
						1 => Phrase::trans(16048,1),
						0 => Phrase::trans(16049,1),
					)); ?>
					<?php echo $form->error($model,'profile_views'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'profile_change'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Phrase::trans(16051,1);?></span>
					<?php echo $form->radioButtonList($model, 'profile_change', array(
						1 => Phrase::trans(16052,1),
						0 => Phrase::trans(16053,1),
					)); ?>
					<?php echo $form->error($model,'profile_change'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'profile_delete'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Phrase::trans(16055,1);?></span>
					<?php echo $form->radioButtonList($model, 'profile_delete', array(
						1 => Phrase::trans(16056,1),
						0 => Phrase::trans(16057,1),
					)); ?>
					<?php echo $form->error($model,'profile_delete'); ?>
				</div>
			</div>

			<div class="submit clearfix">
				<label>&nbsp;</label>
				<div class="desc">
					<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0) ,array('onclick' => 'setEnableSave()')); ?>
				</div>
			</div>

		</fieldset>

	<?php $this->endWidget(); ?>
</div>