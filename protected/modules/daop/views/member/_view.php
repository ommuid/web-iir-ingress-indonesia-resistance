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
	<div class="city" title="<?php echo $data->city_relation->city?>">
		<?php echo $data->city_relation->city?>
		<div class="more">
			<a href="<?php echo Yii::app()->controller->createUrl('city/view',array('id'=>$data->city_id,'t'=>Utility::getUrlTitle($data->city_relation->city)))?>" title="Detail: <?php echo $data->city_relation->city?>">Detail</a>
			<a href="<?php echo Yii::app()->controller->createUrl('delete',array('id'=>$data->daop_id))?>" title="Drop: <?php echo $data->city_relation->city?>">Drop</a>
		</div>
	</div>
	<span><?php echo Utility::dateFormat($data->creation_date, true);?></span>
</div>