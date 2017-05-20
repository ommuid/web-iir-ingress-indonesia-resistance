<?php
/**
 * Banner Views (banner-views)
 * @var $this ViewController
 * @var $model BannerViews
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 8 January 2017, 20:54 WIB
 * @link https://github.com/ommu/Banner
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Banner Views'=>array('manage'),
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
				//'value'=>$model->view_id != '' ? $model->view_id : '-',
			),
			array(
				'name'=>'banner_id',
				'value'=>$model->banner_id,
				//'value'=>$model->banner_id != '' ? $model->banner_id : '-',
			),
			array(
				'name'=>'user_id',
				'value'=>$model->user_id,
				//'value'=>$model->user_id != '' ? $model->user_id : '-',
			),
			array(
				'name'=>'views',
				'value'=>$model->views,
				//'value'=>$model->views != '' ? $model->views : '-',
			),
			array(
				'name'=>'view_date',
				'value'=>!in_array($model->view_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->view_date, true) : '-',
			),
			array(
				'name'=>'view_ip',
				'value'=>$model->view_ip,
				//'value'=>$model->view_ip != '' ? $model->view_ip : '-',
			),
		),
	)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
