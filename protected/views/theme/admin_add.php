<?php
/**
 * Ommu Themes (ommu-themes)
 * @var $this ThemeController
 * @var $model OmmuThemes
 * @var $form CActiveForm
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Themes'=>array('manage'),
		'Create',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>