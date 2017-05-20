<?php
/**
 * Ommu Zone Districts (ommu-zone-districts)
 * @var $this ZonedistrictController
 * @var $model OmmuZoneDistricts
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
		'Ommu Zone Districts'=>array('manage'),
		'Create',
	);
?>

<div class="form">
	<?php echo $this->renderPartial('/zone_district/_form', array('model'=>$model)); ?>
</div>
