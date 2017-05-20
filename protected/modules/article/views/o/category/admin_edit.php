<?php
/**
 * Article Category (article-category)
 * @var $this CategoryController
 * @var $model ArticleCategory
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Articles
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Article Categories'=>array('manage'),
		$model->name=>array('view','id'=>$model->cat_id),
		'Update',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>