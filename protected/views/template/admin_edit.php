<?php
/**
 * Ommu Templates (ommu-template)
 * @var $this TemplateController
 * @var $model OmmuTemplate
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
		'Ommu Templates'=>array('manage'),
		$model->template_key=>array('view','id'=>$model->template_key),
		'Update',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>