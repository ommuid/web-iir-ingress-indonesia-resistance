<?php
/**
 * Banners (banners)
 * @var $this AdminController
 * @var $model Banners
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
		'Banners'=>array('manage'),
		$model->title=>array('view','id'=>$model->banner_id),
		'Update',
	);
?>

<div class="form">
	<?php echo $this->renderPartial('_form', array(
		'model'=>$model,
		'banner_file_type'=>$banner_file_type,
	)); ?>
</div>
