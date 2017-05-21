<?php
/**
 * Daop Cities (daop-city)
 * @var $this CityController
 * @var $model DaopCity
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$name = $data->user_relation->username != '' ? $data->user_relation->username : $data->user_relation->displayname;
	$city = DaopUsers::model()->count(array(
		//'select'=>'folder, layout',
		'condition' => 'user_id = :id',
		'params' => array(
			':id' => $data->user_id,
		),		
	));
	$another = DaopAnotherUser::model()->count(array(
		//'select'=>'folder, layout',
		'condition' => 'user_id = :id',
		'params' => array(
			':id' => $data->user_id,
		),		
	));
	
?>
<div class="sep">
	<a class="users" href="javascript:void(0);" title="<?php echo $name;?>"><?php echo $name;?></a>
	<div>
		<a href="javascript:void(0);" title="<?php echo $city;?> City"><?php echo $city;?> City</a> and 
		<a href="javascript:void(0);" title="<?php echo $another;?> Specific Area"><?php echo $another;?> Specific Area</a>
	</div>
</div>