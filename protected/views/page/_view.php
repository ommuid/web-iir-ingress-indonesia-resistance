<?php
/**
 * @var $this OmmuPagesController
 * @var $data OmmuPages
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('page_id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->page_id), array('view', 'id'=>$data->page_id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
    <?php echo CHtml::encode($data->user_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('publish')); ?>:</b>
    <?php echo CHtml::encode($data->publish); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('desc')); ?>:</b>
    <?php echo CHtml::encode($data->desc); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('media')); ?>:</b>
    <?php echo CHtml::encode($data->media); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('media_show')); ?>:</b>
    <?php echo CHtml::encode($data->media_show); ?>
    <br />

    <?php /*
    <b><?php echo CHtml::encode($data->getAttributeLabel('media_type')); ?>:</b>
    <?php echo CHtml::encode($data->media_type); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>:</b>
    <?php echo CHtml::encode($data->creation_date); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('modified_date')); ?>:</b>
    <?php echo CHtml::encode($data->modified_date); ?>
    <br />

    */ ?>

</div>