<?php
/**
 * Banner Categories (banner-category)
 * @var $this CategoryController
 * @var $model BannerCategory
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Banner
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Banner Categories'=>array('manage'),
		$model->name=>array('view','id'=>$model->cat_id),
		'Update',
	);
?>

<div class="form">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
