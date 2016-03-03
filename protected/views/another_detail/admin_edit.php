<?php
/**
 * @var $this AnotherdetailController
 * @var $model OmmuAnotherDetails
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Another Details'=>array('manage'),
		$model->another_id=>array('view','id'=>$model->another_id),
		'Update',
	);
?>

<div class="form">
	<?php echo $this->renderPartial('/another_detail/_form', array('model'=>$model)); ?>
</div>
