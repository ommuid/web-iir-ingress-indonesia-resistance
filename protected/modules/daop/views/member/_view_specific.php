<?php
/**
 * Daop Users (daop-users)
 * @var $this MemberController * @var $data DaopUsers *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<div class="sep">
	<div class="city" title="<?php echo $data->another_relation->another_name?>">
		<?php echo $data->another_relation->another_name?>
		<div class="more">
			<a href="<?php echo Yii::app()->controller->createUrl('another/view',array('id'=>$data->another_id,'t'=>Utility::getUrlTitle($data->another_relation->another_name)))?>" title="Detail: <?php echo $data->another_relation->another_name?>">Detail</a>
			<a href="<?php echo Yii::app()->controller->createUrl('delete',array('id'=>$data->id))?>" title="Drop: <?php echo $data->another_relation->another_name?>">Drop</a>
		</div>
	</div>
	<span><?php echo Utility::dateFormat($data->creation_date, true);?></span>
</div>