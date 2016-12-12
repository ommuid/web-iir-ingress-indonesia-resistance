<?php
/**
 * Ommu Pages (ommu-pages)
 * @var $this OmmuPagesController
 * @var $model OmmuPages
 * version: 1.1.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contact (+62)856-299-4114
 *
 */
 
	$this->breadcrumbs=array(
		'Ommu Pages'=>array('manage'),
		$model->name,
	);
?>

<?php if(($a == null && $model->media_show == 1) || ($a != null && $model->media_show == 'show')) {
	if($a == null)
		$images = Yii::app()->request->baseUrl.'/public/page/'.$model->media;
	else
		$images = $model->media_image;
		
	if($this->adsSidebar == true) {
		if(($a == null && $model->media_type == 1) || ($a != null && $model->media_type == 'large'))
			echo '<img class="largemag" src="'.Utility::getTimThumb($images, 600, 900, 3).'" alt="">';
		else
			echo '<img class="mediummag" src="'.Utility::getTimThumb($images, 270, 500, 3).'" alt="">';
	} else {
		if(($a == null && $model->media_type == 1) || ($a != null && $model->media_type == 'large'))
			echo '<img class="largemag" src="'.Utility::getTimThumb($images, 1280, 1024, 3).'" alt="">';
		else
			echo '<img class="mediummag" src="'.Utility::getTimThumb($images, 270, 500, 3).'" alt="">';
	}
}?>

<?php if($a == null)
	echo Phrase::trans($model->name, 2) != Utility::hardDecode(Phrase::trans($model->desc, 2)) ? Utility::cleanImageContent(Phrase::trans($model->desc, 2)) : '';
else 
	echo $model->description;?>