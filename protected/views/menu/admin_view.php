<?php
/**
 * Ommu Menus (ommu-menu)
 * @var $this MenuController
 * @var $model OmmuMenu
 * version: 1.1.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 24 March 2016, 10:20 WIB
 * @link https://github.com/oMMu/Ommu-Core
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Menus'=>array('manage'),
		$model->name,
	);
?>

<?php //begin.Messages ?>
<?php
if(Yii::app()->user->hasFlash('success'))
	echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
?>
<?php //end.Messages ?>

<?php $this->widget('application.components.system.FDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'id',
			'value'=>$model->id,
			//'value'=>$model->id != '' ? $model->id : '-',
		),
		array(
			'name'=>'publish',
			'value'=>$model->publish == '1' ? Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
			//'value'=>$model->publish,
		),
		array(
			'name'=>'cat_id',
			'value'=>$model->cat_id,
			//'value'=>$model->cat_id != '' ? $model->cat_id : '-',
		),
		array(
			'name'=>'dependency',
			'value'=>$model->dependency,
			//'value'=>$model->dependency != '' ? $model->dependency : '-',
		),
		array(
			'name'=>'orders',
			'value'=>$model->orders,
			//'value'=>$model->orders != '' ? $model->orders : '-',
		),
		array(
			'name'=>'name',
			'value'=>$model->name,
			//'value'=>$model->name != '' ? $model->name : '-',
		),
		array(
			'name'=>'url',
			'value'=>$model->url,
			//'value'=>$model->url != '' ? $model->url : '-',
		),
		array(
			'name'=>'attr',
			'value'=>$model->attr,
			//'value'=>$model->attr != '' ? $model->attr : '-',
		),
		array(
			'name'=>'sitetype_access',
			'value'=>$model->sitetype_access,
			//'value'=>$model->sitetype_access != '' ? $model->sitetype_access : '-',
		),
		array(
			'name'=>'userlevel_access',
			'value'=>$model->userlevel_access,
			//'value'=>$model->userlevel_access != '' ? $model->userlevel_access : '-',
		),
		array(
			'name'=>'creation_date',
			'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->creation_date, true) : '-',
		),
		array(
			'name'=>'creation_id',
			'value'=>$model->creation_id,
			//'value'=>$model->creation_id != 0 ? $model->creation_id : '-',
		),
		array(
			'name'=>'modified_date',
			'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->modified_date, true) : '-',
		),
		array(
			'name'=>'modified_id',
			'value'=>$model->modified_id,
			//'value'=>$model->modified_id != 0 ? $model->modified_id : '-',
		),
	),
)); ?>

<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
