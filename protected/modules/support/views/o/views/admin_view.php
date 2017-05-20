<?php
/**
 * Support Feedback Views (support-feedback-view)
 * @var $this ViewsController
 * @var $model SupportFeedbackView
 * version: 0.2.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 11 May 2017, 23:13 WIB
 * @link https://github.com/ommu/Support
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Support Feedback Views'=>array('manage'),
		$model->view_id,
	);
?>

<div class="dialog-content">
	<?php $this->widget('application.components.system.FDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'view_id',
				'value'=>$model->view_id,
			),
			array(
				'name'=>'feedback_id',
				'value'=>$model->feedback_id,
				//'value'=>$model->feedback_id != '' ? $model->feedback_id : '-',
			),
			array(
				'name'=>'user_id',
				'value'=>$model->user_id != 0 ? $model->user->displayname : '-',
			),
			array(
				'name'=>'creation_date',
				'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->creation_date, true) : '-',
			),
		),
	)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
