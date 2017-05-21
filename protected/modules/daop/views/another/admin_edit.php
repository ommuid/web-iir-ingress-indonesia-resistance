<?php
/**
 * Daop Anothers (daop-anothers)
 * @var $this AnotherController
 * @var $model DaopAnothers
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Daop Anothers'=>array('manage'),
		$model->another_id=>array('view','id'=>$model->another_id),
		'Update',
	);
?>

<div class="form">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
