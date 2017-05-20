<?php
/**
 * Ommu Authors (ommu-authors)
 * @var $this AuthorController
 * @var $model OmmuAuthors
 * @var $form CActiveForm
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2015 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Authors'=>array('manage'),
		$model->name=>array('view','id'=>$model->author_id),
		'Update',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
