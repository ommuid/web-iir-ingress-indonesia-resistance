<?php
/**
 * Ommu Languages (ommu-languages)
 * @var $this LanguageController
 * @var $model OmmuLanguages
 * version: 1.1.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Languages'=>array('manage'),
		'Manage',
	);
?>

<div id="partial-language">
	<?php //begin.Messages ?>
	<div id="ajax-message">
	<?php
		if(Yii::app()->user->hasFlash('error'))
			echo Utility::flashError(Yii::app()->user->getFlash('error'));
		if(Yii::app()->user->hasFlash('success'))
			echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
	?>
	</div>
	<?php //begin.Messages ?>

	<div class="boxed">
		<?php //begin.Grid Item ?>
		<?php 
			$columnData   = $columns;
			array_push($columnData, array(
				'header' => Yii::t('phrase', 'Options'),
				'class'=>'CButtonColumn',
				'buttons' => array(
					'view' => array(
						'label' => 'view',
						'options' => array(
							'class' => 'view'
						),
						'url' => 'Yii::app()->controller->createUrl("view",array("id"=>$data->primaryKey))'),
					'update' => array(
						'label' => 'update',
						'options' => array(
							'class' => 'update'
						),
						'url' => 'Yii::app()->controller->createUrl("edit",array("id"=>$data->primaryKey))'),
					'delete' => array(
						'label' => 'delete',
						'options' => array(
							'class' => 'delete'
						),
						'url' => 'Yii::app()->controller->createUrl("delete",array("id"=>$data->primaryKey))')
				),
				'template' => '{update}|{delete}',
			));

			$this->widget('application.components.system.OGridView', array(
				'id'=>'ommu-languages-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'columns' => $columnData,
				'pager' => array('header' => ''),
			));
		?>
		<?php //end.Grid Item ?>
	</div>
</div>

<?php if($setting->site_type == 1) {?>
<div class="form mt-15" name="post-on">

	<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
		'action' => Yii::app()->controller->createUrl('settings'),
		'id'=>'ommu-settings-form',
		'enableAjaxValidation'=>true,
		//'htmlOptions' => array('enctype' => 'multipart/form-data')
	)); ?>

	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php echo $form->errorSummary($setting); ?>
	</div>
	<?php //begin.Messages ?>

	<fieldset>
		<h3><?php echo Yii::t('phrase', 'Language Selection Settings');?></h3>

		<div class="clearfix">
			<label><span><?php echo Yii::t('phrase', 'If you have more than one language pack, do you want to allow your registered users to select which one will be used while they are logged in? If you select "Yes", users will be able to choose their language on the signup page and the account settings page. Note that this will only apply if you have more than one language pack.');?></span></label>
			<div class="desc">
				<?php echo $form->radioButtonList($setting, 'lang_allow', array(
					1 => Yii::t('phrase', 'Yes, allow registered users to choose their own language.'),
					0 => Yii::t('phrase', 'No, do not allow registered users to save their language preference.'),
				)); ?>
				<?php echo $form->error($setting,'lang_allow'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><span><?php echo Yii::t('phrase', 'If you have more than one language pack, do you want to display a select box on your homepage so that unregistered users can change the language in which they view the social network? Note that this will only apply if you have more than one language pack.');?></span></label>
			<div class="desc">
				<?php echo $form->radioButtonList($setting, 'lang_anonymous', array(
					1 => Yii::t('phrase', 'Yes, display a select box that will allow unregistered users to change their language.'),
					0 => Yii::t('phrase', 'No, do not allow unregistered users to change the site language.'),
				)); ?>
				<?php echo $form->error($setting,'lang_anonymous'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><span><?php echo Yii::t('phrase', 'If you have more than one language pack, do you want the system to autodetect the language settings from your visitors\' browsers? If you select "Yes", the system will attempt to detect what language the user has set in their browser settings. If you have a matching language, your site will display in that language, otherwise it will display in the default language.');?></span></label>
			<div class="desc">
				<?php echo $form->radioButtonList($setting, 'lang_autodetect', array(
					1 => Yii::t('phrase', 'Yes, attempt to detect the visitor\'s language based on their browser settings.'),
					0 => Yii::t('phrase', 'No, do not autodetect the visitor\'s language.'),
				)); ?>
				<?php echo $form->error($setting,'lang_autodetect'); ?>
			</div>
		</div>

		<div class="submit clearfix">
			<label>&nbsp;</label>
			<div class="desc">
				<?php echo CHtml::submitButton($setting->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>

	</fieldset>
	<?php $this->endWidget(); ?>

</div>
<?php }?>




