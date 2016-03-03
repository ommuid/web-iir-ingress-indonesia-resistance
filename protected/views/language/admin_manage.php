<?php
/**
 * @var $this LanguageController
 * @var $model OmmuLanguages
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
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
				'header' => Phrase::trans(151,0),
				'class'=>'CButtonColumn',
				'buttons' => array(
					'phrase' => array(
						'label' => 'phrase',
						'options' => array(
							'class' => 'view'
						),
						'url' => 'Yii::app()->createUrl("phrase/manage",array("id"=>$data->primaryKey))'),
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
				'template' => '{phrase}|{update}|{delete}',
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

<?php if(OmmuSettings::getInfo('site_type') == 1) {?>
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
		<h3><?php echo Phrase::trans(139,0);?></h3>

		<div class="clearfix">
			<label><span><?php echo Phrase::trans(140,0);?></span></label>
			<div class="desc">
				<?php echo $form->radioButtonList($setting, 'lang_allow', array(
					1 => Phrase::trans(141,0),
					0 => Phrase::trans(142,0),
				)); ?>
				<?php echo $form->error($setting,'lang_allow'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><span><?php echo Phrase::trans(143,0);?></span></label>
			<div class="desc">
				<?php echo $form->radioButtonList($setting, 'lang_anonymous', array(
					1 => Phrase::trans(144,0),
					0 => Phrase::trans(145,0),
				)); ?>
				<?php echo $form->error($setting,'lang_anonymous'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><span><?php echo Phrase::trans(146,0);?></span></label>
			<div class="desc">
				<?php echo $form->radioButtonList($setting, 'lang_autodetect', array(
					1 => Phrase::trans(147,0),
					0 => Phrase::trans(148,0),
				)); ?>
				<?php echo $form->error($setting,'lang_autodetect'); ?>
			</div>
		</div>

		<div class="submit clearfix">
			<label>&nbsp;</label>
			<div class="desc">
				<?php echo CHtml::submitButton($setting->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>

	</fieldset>
	<?php $this->endWidget(); ?>

</div>
<?php }?>




