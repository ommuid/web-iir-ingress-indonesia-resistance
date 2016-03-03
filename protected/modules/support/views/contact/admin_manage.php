<?php
/**
 * @var $this ContactsController
 * @var $model SupportContacts
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Support Contacts'=>array('manage'),
		'Manage',
	);
?>

<div class="quick-action celarfix" id="partial-support-contacts">
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
		<h3><?php echo Phrase::trans(23065,1)?></h3>
		<?php //begin.Grid Item ?>
		<?php 
			$columnData   = $columns;
			array_push($columnData, array(
				'header' => Phrase::trans(151,0),
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
				'id'=>'support-contacts-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'columns' => $columnData,
				'pager' => array('header' => ''),
			));
		?>
		<?php //end.Grid Item ?>
	</div>

	<?php //begin.Form ?>
	<div class="form" name="post-on">
		<h3><?php echo Phrase::trans(23071,1)?></h3>
		<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
	<?php //end.Form ?>

</div>
