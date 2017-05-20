<?php
/**
 * Banner Clicks (banner-clicks)
 * @var $this ClickController
 * @var $model BannerClicks
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
		'Banner Clicks'=>array('manage'),
		$model->click_id,
	);
?>

<div class="dialog-content">
	<?php $this->widget('application.components.system.FDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'click_id',
				'value'=>$model->click_id,
				//'value'=>$model->click_id != '' ? $model->click_id : '-',
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
				'name'=>'clicks',
				'value'=>$model->clicks,
				//'value'=>$model->clicks != '' ? $model->clicks : '-',
			),
			array(
				'name'=>'click_date',
				'value'=>!in_array($model->click_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->click_date, true) : '-',
			),
			array(
				'name'=>'click_ip',
				'value'=>$model->click_ip,
				//'value'=>$model->click_ip != '' ? $model->click_ip : '-',
			),
		),
	)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
