<?php
/**
 * Daop Users (daop-users)
 * @var $this MemberController
 * @var $data DaopUsers
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

if($render == 1) {
	if($data->another_photo == '')
		$images = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/daop/daop_default.png', 100, 100, 1);
	else
		$images = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/daop/another/'.$data->another_photo, 100, 100, 1); 
	if($data->city_id != 0)
		$title = $data->another_name.', '.$data->city_relation->city;
	else
		$title = $data->another_name;
?>

	<div class="sep">
		<div class="img">
			<a href="<?php echo Yii::app()->controller->createUrl('anotherdrop',array('id'=>$data->another_id,'t'=>Utility::getUrlTitle($data->another_name)))?>" title="Drop: <?php echo $title?>">Drop</a>
			<img src="<?php echo $images;?>" alt="<?php echo $title;?>" />
		</div>
		<a href="<?php echo Yii::app()->controller->createUrl('another/view',array('id'=>$data->another_id,'t'=>Utility::getUrlTitle($title)))?>" title="<?php echo $title.' ['.$data->users.' Agent]';?>"><?php echo $title;?></a>
	</div>
	
<?php } else {?>
	<div class="empty">
		<h3>Specific City Registered Not Found</h3>
	</div>
<?php }?>