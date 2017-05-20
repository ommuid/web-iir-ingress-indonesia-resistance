<?php
/**
 * Ommu Settings (ommu-settings)
 * @var $this SettingsController
 * @var $model OmmuSettings
 * @var $form CActiveForm
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Settings'=>array('manage'),
		'Manage',
	);
	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$('#OmmuSettings_online input[name="OmmuSettings[online]"]').on('change', function() {
		var id = $(this).val();
		if(id == '0') {
			$('div#construction').slideDown();
		} else {
			$('div#construction').slideUp();
		}
	});
	$('#OmmuSettings_event input[name="OmmuSettings[event]"]').on('change', function() {
		var id = $(this).val();
		if(id == '0') {
			$('div#events').slideUp();
		} else {
			$('div#events').slideDown();
		}
	});
EOP;
	$cs->registerScript('setting', $js, CClientScript::POS_END);
?>

<div class="form" name="post-on">

	<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
		'id'=>'ommu-settings-form',
		'enableAjaxValidation'=>true,
		//'htmlOptions' => array('enctype' => 'multipart/form-data')
	)); ?>

	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php echo $form->errorSummary($model); ?>
	</div>
	<?php //begin.Messages ?>

	<fieldset>
		<div class="clearfix">
			<?php echo $form->labelEx($model,'online'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Yii::t('phrase', 'Maintenance Mode will prevent site visitors from accessing your website. You can customize the maintenance mode page by manually editing the file "/application/maintenance.html".');?></span>
				<?php echo $form->radioButtonList($model, 'online', array(
					1 => Yii::t('phrase', 'Online'),
					0 => Yii::t('phrase', 'Offline (Maintenance Mode)'),
				)); ?>
				<?php echo $form->error($model,'online'); ?>
			</div>
		</div>

		<div id="construction" <?php echo $model->online != '0' ? 'class="hide"' : ''; ?>>
			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('construction_date');?> <span class="required">*</span></label>
				<div class="desc">
					<?php 
					$model->construction_date = date('d-m-Y', strtotime($model->construction_date));
					//echo $form->textField($model,'construction_date',array('maxlength'=>10, 'class'=>'span-3'));
					$this->widget('application.components.system.CJuiDatePicker',array(
						'model'=>$model, 
						'attribute'=>'construction_date',
						'options'=>array(
							'dateFormat' => 'dd-mm-yy',
						),
						'htmlOptions'=>array(
							'class' => 'span-4',
						 ),
					));	?>
					<?php echo $form->error($model,'construction_date'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('construction_text')?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->textArea($model,'construction_text',array('rows'=>6, 'cols'=>50, 'class'=>'span-9 small')); ?>
					<?php echo $form->error($model,'construction_text'); ?>
				</div>
			</div>

		</div>

		<?php 
		$model->event = 0;
		if($model->isNewRecord || (!$model->isNewRecord && !in_array(date('Y-m-d', strtotime($model->event_startdate)), array('0000-00-00','1970-01-01')) && !in_array(date('Y-m-d', strtotime($model->event_finishdate)), array('0000-00-00','1970-01-01'))))
			$model->event = 1;
		?>
		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('event')?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->radioButtonList($model,'event', array(
					1 => 'Enable',
					0 => 'Disable',
				)); ?>
				<?php echo $form->error($model,'event'); ?>
			</div>
		</div>
		
		<div id="events" <?php echo $model->event == '0' ? 'class="hide"' : ''; ?>>
			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('event_startdate');?> <span class="required">*</span></label>
				<div class="desc">
					<?php 
					$model->event_startdate = date('d-m-Y', strtotime($model->event_startdate));
					//echo $form->textField($model,'event_startdate',array('maxlength'=>10, 'class'=>'span-3'));
					$this->widget('application.components.system.CJuiDatePicker',array(
						'model'=>$model, 
						'attribute'=>'event_startdate',
						'options'=>array(
							'dateFormat' => 'dd-mm-yy',
						),
						'htmlOptions'=>array(
							'class' => 'span-4',
						 ),
					));	?>
					<?php echo $form->error($model,'event_startdate'); ?>
				</div>
			</div>
			
			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('event_finishdate');?> <span class="required">*</span></label>
				<div class="desc">
					<?php 
					$model->event_finishdate = date('d-m-Y', strtotime($model->event_finishdate));
					//echo $form->textField($model,'event_finishdate',array('maxlength'=>10, 'class'=>'span-3'));
					$this->widget('application.components.system.CJuiDatePicker',array(
						'model'=>$model, 
						'attribute'=>'event_finishdate',
						'options'=>array(
							'dateFormat' => 'dd-mm-yy',
						),
						'htmlOptions'=>array(
							'class' => 'span-4',
						 ),
					));	?>
					<?php echo $form->error($model,'event_finishdate'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('event_tag')?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->textArea($model,'event_tag',array('rows'=>6, 'cols'=>50, 'class'=>'span-9 smaller')); ?>
					<?php echo $form->error($model,'event_tag'); ?>
				</div>
			</div>
		</div>

		<div class="clearfix">
			<label>
				<?php echo $model->getAttributeLabel('site_title');?> <span class="required">*</span><br/>
				<span><?php echo Yii::t('phrase', 'Give your community a unique name. This will appear in the &lt;title&gt; tag throughout most of your site.');?></span>
			</label>
			<div class="desc">
				<?php echo $form->textField($model,'site_title',array('maxlength'=>256, 'class'=>'span-5')); ?>
				<?php echo $form->error($model,'site_title'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('site_url')?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->textField($model,'site_url',array('maxlength'=>32, 'class'=>'span-5')); ?>
				<?php echo $form->error($model,'site_url'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label>
				<?php echo $model->getAttributeLabel('site_description');?> <span class="required">*</span><br/>
				<span><?php echo Yii::t('phrase', 'Enter a brief, concise description of your community. Include any key words or phrases that you want to appear in search engine listings.');?></span>
			</label>
			<div class="desc">
				<?php echo $form->textArea($model,'site_description',array('rows'=>6, 'cols'=>50, 'class'=>'span-9', 'maxlength'=>256)); ?>
				<?php echo $form->error($model,'site_description'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label>
				<?php echo $model->getAttributeLabel('site_keywords');?> <span class="required">*</span><br/>
				<span><?php echo Yii::t('phrase', 'Provide some keywords (separated by commas) that describe your community. These will be the default keywords that appear in the <meta> tag in your page header. Enter the most relevant keywords you can think of to help your community\'s search engine rankings.');?></span>
			</label>
			<div class="desc">
				<?php echo $form->textArea($model,'site_keywords',array('rows'=>6, 'cols'=>50, 'class'=>'span-9', 'maxlength'=>256)); ?>
				<?php echo $form->error($model,'site_keywords'); ?>
			</div>
		</div>

		<?php if(OmmuSettings::getInfo('site_type') == 1) {?>
		<div class="clearfix">
			<label>
				<?php echo Yii::t('phrase', 'Public Permission Defaults');?>
				<span><?php echo Yii::t('phrase', 'Select whether or not you want to let the public (visitors that are not logged-in) to view the following sections of your social network. In some cases (such as Profiles), if you have given them the option, your users will be able to make their pages private even though you have made them publically viewable here.');?></span>
			</label>
			<div class="desc">
				<p><?php echo $model->getAttributeLabel('general_profile');?></p>
				<?php echo $form->radioButtonList($model, 'general_profile', array(
					1 => Yii::t('phrase', 'Yes, the public can view profiles unless they are made private.'),
					0 => Yii::t('phrase', 'No, the public cannot view profiles.'),
				)); ?>
				<?php echo $form->error($model,'general_profile'); ?>

				<p><?php echo $model->getAttributeLabel('general_invite');?></p>
				<?php echo $form->radioButtonList($model, 'general_invite', array(
					1 => Yii::t('phrase', 'Yes, the public can use the invite page.'),
					0 => Yii::t('phrase', 'No, the public cannot use the invite page.'),
				)); ?>
				<?php echo $form->error($model,'general_invite'); ?>

				<p><?php echo $model->getAttributeLabel('general_search');?></p>
				<?php echo $form->radioButtonList($model, 'general_search', array(
					1 => Yii::t('phrase', 'Yes, the public can use the search page.'),
					0 => Yii::t('phrase', 'No, the public cannot use the search page.'),
				)); ?>
				<?php echo $form->error($model,'general_search'); ?>

				<p><?php echo $model->getAttributeLabel('general_portal');?></p>
				<?php echo $form->radioButtonList($model, 'general_portal', array(
					1 => Yii::t('phrase', 'Yes, the public view use the portal page.'),
					0 => Yii::t('phrase', 'No, the public cannot view the portal page.'),
				)); ?>
				<?php echo $form->error($model,'general_portal'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo Yii::t('phrase', 'Enable Username?');?></label>
			<div class="desc">
				<span class="small-px"><?php echo Yii::t('phrase', 'By default, usernames are used to uniquely identify your users. If you choose to disable this feature, your users will not be given the option to enter a username. Instead, their user ID will be used. Note that if you do decide to enable this feature, you should make sure to create special REQUIRED display name profile fields - otherwise the users\' IDs will be displayed. Also note that if you disable usernames after users have already signed up, their usernames will be deleted and any previous links to their content will not work, as the links will no longer use their username! Finally, all recent activity and all notifications will be deleted if you choose to disable usernames after previously having them enabled.');?></span>
				<?php echo $form->radioButtonList($model, 'signup_username', array(
					1 => Yii::t('phrase', 'Yes, users are uniquely identified by their username.'),
					0 => Yii::t('phrase', 'No, usernames will not be used in this network.'),
				)); ?>
				<?php echo $form->error($model,'signup_username'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>
		<?php }?>

		<div class="clearfix">
			<label>
				<?php echo $model->getAttributeLabel('general_include');?>
				<span><?php echo Yii::t('phrase', 'Anything entered into the box below will be included at the bottom of the &lt;head&gt; tag. If you want to include a script or stylesheet, be sure to use the &lt;script&gt; or &lt;link&gt; tag.');?></span>
			</label>
			<div class="desc">
				<?php echo $form->textArea($model,'general_include',array('rows'=>6, 'cols'=>50, 'class'=>'span-9')); ?>
				<?php echo $form->error($model,'general_include'); ?>
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

</div>