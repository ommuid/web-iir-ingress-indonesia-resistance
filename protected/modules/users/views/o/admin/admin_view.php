<?php
/**
 * Users (users)
 * @var $this AdminController
 * @var $model Users
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 25 February 2016, 15:47 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Users'=>array('manage'),
		$model->user_id,
	);
?>

<div class="dialog-content">
<?php $this->widget('application.components.system.FDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'user_id',
			'value'=>$model->user_id,
		),
		array(
			'name'=>'source_id',
			'value'=>$model->source_id,
		),
		array(
			'name'=>'level_id',
			'value'=>$model->level_id,
		),
		array(
			'name'=>'profile_id',
			'value'=>$model->profile_id,
		),
		array(
			'name'=>'language_id',
			'value'=>$model->language_id,
		),
		array(
			'name'=>'email',
			'value'=>$model->email,
		),
		array(
			'name'=>'displayname',
			'value'=>$model->displayname,
		),
		array(
			'name'=>'photos',
			'value'=>$model->photos != '' ? CHtml::link($model->photos, $model->photos, array('target' => '_blank')) : '-',
			'type'=>'raw',
		),
		array(
			'name'=>'enabled',
			'value'=>$model->enabled,
		),
		array(
			'name'=>'verified',
			'value'=>$model->verified,
		),
		array(
			'name'=>'creation_date',
			'value'=>Utility::dateFormat($model->creation_date, true),
		),
		array(
			'name'=>'creation_ip',
			'value'=>$model->creation_ip,
		),
		array(
			'name'=>'lastlogin_date',
			'value'=>Utility::dateFormat($model->lastlogin_date, true),
		),
		array(
			'name'=>'lastlogin_ip',
			'value'=>$model->lastlogin_ip,
		),
		array(
			'name'=>'lastlogin_from',
			'value'=>$model->lastlogin_from,
		),
	),
)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
