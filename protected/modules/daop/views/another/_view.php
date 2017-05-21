<?php
/**
 * Daop Anothers (daop-anothers)
 * @var $this AnotherController
 * @var $data DaopAnothers
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('another_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->another_id), array('view', 'id'=>$data->another_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('another_name')); ?>:</b>
	<?php echo CHtml::encode($data->another_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('another_desc')); ?>:</b>
	<?php echo CHtml::encode($data->another_desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('another_cover')); ?>:</b>
	<?php echo CHtml::encode($data->another_cover); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('another_photo')); ?>:</b>
	<?php echo CHtml::encode($data->another_photo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_id')); ?>:</b>
	<?php echo CHtml::encode($data->country_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('province_id')); ?>:</b>
	<?php echo CHtml::encode($data->province_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city_id')); ?>:</b>
	<?php echo CHtml::encode($data->city_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('users')); ?>:</b>
	<?php echo CHtml::encode($data->users); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>:</b>
	<?php echo CHtml::encode($data->creation_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creation_id')); ?>:</b>
	<?php echo CHtml::encode($data->creation_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_date')); ?>:</b>
	<?php echo CHtml::encode($data->modified_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_id')); ?>:</b>
	<?php echo CHtml::encode($data->modified_id); ?>
	<br />

	*/ ?>

</div>