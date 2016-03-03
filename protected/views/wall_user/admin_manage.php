<?php
/**
 * Ommu Wall Users (ommu-wall-user)
 * @var $this WalluserController * @var $model OmmuWallUser *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Wall Users'=>array('manage'),
		'Manage',
	);
	$this->menu=array(
		array(
			'label' => Phrase::trans(307,0), 
			'url' => array('javascript:void(0);'),
			'itemOptions' => array('class' => 'search-button'),
			'linkOptions' => array('title' => Phrase::trans(307,0)),
		),
		array(
			'label' => Phrase::trans(308,0), 
			'url' => array('javascript:void(0);'),
			'itemOptions' => array('class' => 'grid-button'),
			'linkOptions' => array('title' => Phrase::trans(308,0)),
		),
	);

?>

<?php //begin.Search ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
<?php //end.Search ?>

<?php //begin.Grid Option ?>
<div class="grid-form">
<?php $this->renderPartial('_option_form',array(
	'model'=>$model,
)); ?>
</div>
<?php //end.Grid Option ?>

<div id="partial-ommu-wall-user">
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
			$this->widget('application.components.system.OGridView', array(
				'id'=>'ommu-wall-user-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'columns' => $columnData,
				'pager' => array('header' => ''),
			));
		?>
		<?php //end.Grid Item ?>
	</div>
</div>