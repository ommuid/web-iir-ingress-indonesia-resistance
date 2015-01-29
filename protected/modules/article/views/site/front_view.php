<?php
/**
 * @var $this SiteController
 * @var $model Articles
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		Phrase::trans(26000,1)=>array('index'),
		Phrase::trans($model->cat->name,2),
	);
?>

<?php $this->widget('application.components.system.FDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'article_id',
		'cat_id',
		'user_id',
		'publish',
		'creation_date',
		'modified_date',
		'published_date',
		'comment_code',
		'comment',
		'view',
		'media_id',
		'title',
		'body',
	),
)); ?>
