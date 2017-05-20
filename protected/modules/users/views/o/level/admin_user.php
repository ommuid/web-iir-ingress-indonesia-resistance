<?php
/**
 * User Levels (user-level)
 * @var $this LevelController
 * @var $model UserLevel
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

		<h3><?php echo Yii::t('phrase', 'User Settings');?></h3>
		<fieldset>

			<div class="intro">
				<?php echo Yii::t('phrase', 'This page contains various settings that affect your users\' accounts.');?>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'profile_block'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Yii::t('phrase', 'If set to "yes", users can block other users from sending them private messages, requesting their friendship, and viewing their profile. This helps fight spam and network abuse.');?></span>
					<?php echo $form->radioButtonList($model, 'profile_block', array(
						1 => Yii::t('phrase', 'Yes, users can block other users.'),
						0 => Yii::t('phrase', 'No, users cannot block other users.'),
					)); ?>
					<?php echo $form->error($model,'profile_block'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo Yii::t('phrase', 'Privacy Options');?></label>
				<div class="desc">
					<p><?php echo Yii::t('phrase', 'Search Privacy Options');?></p>
					<span class="desc"><?php echo Yii::t('phrase', 'If you enable this feature, users will be able to exclude themselves from search results and the lists of users on the homepage (such as Recent Signups). Otherwise, all users will be included in search results.');?></span>
					<?php echo $form->radioButtonList($model, 'profile_search', array(
						1 => Yii::t('phrase', 'Yes, allow users to exclude themselves from search results. '),
						0 => Yii::t('phrase', 'No, force all users to be included in search results.  '),
					)); ?>
					<?php echo $form->error($model,'profile_search'); ?>

					<p><?php echo Yii::t('phrase', 'Profile Privacy Options');?></p>
					<span class="desc"><?php echo Yii::t('phrase', 'Your users can choose from any of the options checked below when they decide who can see their profile. If you do not check any options, everyone will be allowed to view profiles.');?></span>
					<?php 
					if(!$model->getErrors())
						$model->profile_privacy = unserialize($model->profile_privacy);
					echo $form->checkBoxList($model, 'profile_privacy', array(
						1 => Yii::t('phrase', 'Everyone'),
						2 => Yii::t('phrase', 'All Registered Users'),
						3 => Yii::t('phrase', 'Only My Friends and Everyone within My Subnetwork'),
						4 => Yii::t('phrase', 'Only My Friends and Their Friends within My Subnetwork'),
						5 => Yii::t('phrase', 'Only My Friends'),
						6 => Yii::t('phrase', 'Only Me'),
					)); ?>
					<?php echo $form->error($model,'profile_privacy'); ?>

					<p><?php echo Yii::t('phrase', 'Profile Comment Options');?></p>
					<span class="desc"><?php echo Yii::t('phrase', 'Your users can choose from any of the options checked below when they decide who can post comments on their profile. If you do not check any options, everyone will be allowed to post comments on profiles.');?></span>
					<?php 
					if(!$model->getErrors())
						$model->profile_comments = unserialize($model->profile_comments);
					echo $form->checkBoxList($model, 'profile_comments', array(
						1 => Yii::t('phrase', 'Everyone'),
						2 => Yii::t('phrase', 'All Registered Users'),
						3 => Yii::t('phrase', 'Only My Friends and Everyone within My Subnetwork'),
						4 => Yii::t('phrase', 'Only My Friends and Their Friends within My Subnetwork'),
						5 => Yii::t('phrase', 'Only My Friends'),
						6 => Yii::t('phrase', 'Only Me'),
					)); ?>
					<?php echo $form->error($model,'profile_comments'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'photo_allow'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Yii::t('phrase', 'If you enable this feature, users can upload a small photo icon of themselves. This will be shown next to their name/username on their profiles, in search/browse results, next to their private messages, etc.');?></span>
					<?php echo $form->radioButtonList($model, 'photo_allow', array(
						1 => Yii::t('phrase', 'Yes, users can upload a photo.'),
						0 => Yii::t('phrase', 'No, users can not upload a photo.'),
					)); ?>
					<?php echo $form->error($model,'photo_allow'); ?>

					<span class="small-px"><?php echo Yii::t('phrase', 'If you have selected "Yes" above, please input the maximum dimensions for the user photos. If your users upload a photo that is larger than these dimensions, the server will attempt to scale them down automatically. This feature requires that your PHP server is compiled with support for the GD Libraries.');?></span>
					<?php echo Yii::t('phrase', 'Maximum Width:');?>&nbsp;
					<?php 
					if(!$model->getErrors())
						$model->photo_size = unserialize($model->photo_size);
					echo $form->textField($model,'photo_size[width]'); ?>&nbsp;<?php echo Yii::t('phrase', '(in pixels, between 1 and 999)');?><br/>
					<?php echo $form->error($model,'photo_size[width]'); ?>

					<?php echo Yii::t('phrase', 'Maximum Height:');?>&nbsp;
					<?php echo $form->textField($model,'photo_size[height]'); ?>&nbsp;<?php echo Yii::t('phrase', '(in pixels, between 1 and 999)');?><br/>
					<?php echo $form->error($model,'photo_size[height]'); ?><br/>
					<?php echo $form->error($model,'photo_size'); ?>

					<span class="small-px"><?php echo Yii::t('phrase', 'What file types do you want to allow for user photos (gif, jpg, jpeg, or png)? Separate file types with commas, i.e. jpg, jpeg, gif, png');?></span>
					<?php echo Yii::t('phrase', 'Allowed File Types:');?>&nbsp;
					<?php 
					if(!$model->getErrors()) {
						$photo_exts = unserialize($model->photo_exts);
						if(!empty($photo_exts))
							$model->photo_exts = Utility::formatFileType($photo_exts, false);
					}
					echo $form->textField($model,'photo_exts',array('maxlength'=>32)); ?><br/>
					<?php echo $form->error($model,'photo_exts'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'profile_style'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Yii::t('phrase', 'Enable this feature if you want to allow users to customize the colors and fonts of their profiles with their own CSS styles.');?></span>
					<?php echo $form->radioButtonList($model, 'profile_style', array(
						1 => Yii::t('phrase', 'Yes, users can add custom CSS styles to their profiles.'),
						0 => Yii::t('phrase', 'No, users cannot add custom CSS styles to their profiles.'),
					)); ?>
					<?php echo $form->error($model,'profile_style'); ?>

					<span class="small-px"><?php echo Yii::t('phrase', 'Enable this feature if you want your users to choose from existing CSS samples. To add additional samples, simply insert a row into the se_stylesamples database table containing the exact CSS code that should be entered into the Profile Style textarea and, optionally, the path to a thumbnail for the template.');?></span>
					<?php echo $form->radioButtonList($model, 'profile_style_sample', array(
						1 => Yii::t('phrase', 'Yes, users can choose from the provided sample CSS.'),
						0 => Yii::t('phrase', 'No, users can not choose from the provided sample CSS.'),
					)); ?>
					<?php echo $form->error($model,'profile_style_sample'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'profile_status'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Yii::t('phrase', 'Enable this feature if you want to allow users to show their "status" on their profile. By updating their status, users can tell others what they are up to, what\'s on their minds, etc.');?></span>
					<?php echo $form->radioButtonList($model, 'profile_status', array(
						1 => Yii::t('phrase', 'Yes, allow users to have a "status" message.'),
						0 => Yii::t('phrase', 'No, users cannot have a "status" message.'),
					)); ?>
					<?php echo $form->error($model,'profile_status'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'profile_invisible'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Yii::t('phrase', 'Enable this feature if you want to allow users to go "invisible" (not be displayed in the online users list even if they are online).');?></span>
					<?php echo $form->radioButtonList($model, 'profile_invisible', array(
						1 => Yii::t('phrase', 'Yes, allow users to go invisible.'),
						0 => Yii::t('phrase', 'No, do not allow users to go invisible.'),
					)); ?>
					<?php echo $form->error($model,'profile_invisible'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'profile_views'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Yii::t('phrase', 'If you enable this feature, users will be given the option of seeing which users have visited their profile.');?></span>
					<?php echo $form->radioButtonList($model, 'profile_views', array(
						1 => Yii::t('phrase', 'Yes, allow users to see who has viewed their profile.'),
						0 => Yii::t('phrase', 'No, do not allow users to see who has viewed their profile.'),
					)); ?>
					<?php echo $form->error($model,'profile_views'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'profile_change'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Yii::t('phrase', 'Enable this feature if you want to allow your users to be able to change their username. Note that if you have usernames disabled on the General Settings page, this feature is irrelevant.');?></span>
					<?php echo $form->radioButtonList($model, 'profile_change', array(
						1 => Yii::t('phrase', 'Yes, allow users to change their username.'),
						0 => Yii::t('phrase', 'No, do not allow users to change their username.'),
					)); ?>
					<?php echo $form->error($model,'profile_change'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'profile_delete'); ?>
				<div class="desc">
					<span class="small-px"><?php echo Yii::t('phrase', 'Enable this feature if you would like to allow your users to delete their account manually.');?></span>
					<?php echo $form->radioButtonList($model, 'profile_delete', array(
						1 => Yii::t('phrase', 'Yes, allow users to delete their account.'),
						0 => Yii::t('phrase', 'No, do not allow users to delete their account.
'),
					)); ?>
					<?php echo $form->error($model,'profile_delete'); ?>
				</div>
			</div>

			<div class="submit clearfix">
				<label>&nbsp;</label>
				<div class="desc">
					<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
				</div>
			</div>

		</fieldset>

	<?php $this->endWidget(); ?>
</div>