<?php
/**
 * Daop Provinces (daop-province)
 * @var $this ProvinceController * @var $data DaopProvince *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('province_id')); ?>:</b>
	<?php echo CHtml::encode($data->province_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('province_desc')); ?>:</b>
	<?php echo CHtml::encode($data->province_desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('province_cover')); ?>:</b>
	<?php echo CHtml::encode($data->province_cover); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('province_photo')); ?>:</b>
	<?php echo CHtml::encode($data->province_photo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('users')); ?>:</b>
	<?php echo CHtml::encode($data->users); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>:</b>
	<?php echo CHtml::encode($data->creation_date); ?>
	<br />

	<?php /*
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