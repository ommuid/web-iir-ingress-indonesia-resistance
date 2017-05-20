<?php
/**
 * Banners (banners)
 * @var $this AdminController
 * @var $model Banners
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Banner
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Banners'=>array('manage'),
		$model->title,
	);
?>

<div class="box">
	<?php $this->widget('application.components.system.FDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'cat_id',
				'value'=>Phrase::trans($model->category->name),
			),
			'title',
			array(
				'name'=>'url',
				'value'=>CHtml::link($model->url, $model->url, array('target' => '_blank')),
				'type' => 'raw',
			),
			array(
				'name'=>'url',
				'value'=>CHtml::link($model->banner_filename, Yii::app()->request->baseUrl.'/public/banner/'.$model->banner_filename, array('target' => '_blank')),
				'type' => 'raw',
			),
			array(
				'name'=>'published_date',
				'value'=>Utility::dateFormat($model->published_date),
			),
			array(
				'name'=>'expired_date',
				'value'=>Utility::dateFormat($model->expired_date),
			),
			'view',
			'click',
			array(
				'name'=>'creation_date',
				'value'=>Utility::dateFormat($model->creation_date, true),
			),
			array(
				'name'=>'creation_id',
				'value'=>$model->creation->displayname,
			),
			array(
				'name'=>'modified_date',
				'value'=>Utility::dateFormat($model->modified_date, true),
			),
			array(
				'name'=>'modified_id',
				'value'=>$model->modified->displayname,
			),
			array(
				'name'=>'publish',
				'value'=>$model->publish == 1 ? Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
				'type' => 'raw',
			),
		),
	)); ?>
</div>