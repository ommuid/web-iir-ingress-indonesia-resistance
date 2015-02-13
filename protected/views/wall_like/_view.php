<?php
/**
 * Ommu Wall Likes (ommu-wall-likes)
 * @var $this WalllikeController * @var $data OmmuWallLikes *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('like_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->like_id), array('view', 'id'=>$data->like_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wall_id')); ?>:</b>
	<?php echo CHtml::encode($data->wall_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('likes_date')); ?>:</b>
	<?php echo CHtml::encode($data->likes_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('likes_ip')); ?>:</b>
	<?php echo CHtml::encode($data->likes_ip); ?>
	<br />


</div>