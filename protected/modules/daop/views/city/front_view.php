<?php
/**
 * Daop Cities (daop-city)
 * @var $this CityController * @var $model DaopCity *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Daop Cities'=>array('manage'),
		$model->id,
	);
	$action = strtolower(Yii::app()->controller->action->id);
	$cs = Yii::app()->getClientScript();
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/externals/daop/custom_daop.js', CClientScript::POS_END);
?>

<div class="boxed box-info">
	<?php
		if($model->city_cover == '')
			$imageCover = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/daop/daop_default.png', 800, 250, 1);
		else
			$imageCover = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/daop/city/'.$model->city_cover, 800, 250, 1);
		if($model->city_photo == '')
			$images = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/daop/daop_default.png', 120, 120, 1);
		else
			$images = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/daop/city/'.$model->city_photo, 120, 120, 1);
	?>
	<div class="info">
		<img class="cover" src="<?php echo $imageCover;?>" alt="<?php echo $model->city_relation->city?>" />
		<div>
			<a class="photo" href="" title=""><img src="<?php echo $images;?>" alt="<?php echo $model->city_relation->city?>" /></a>
			<h3><?php echo $model->city_relation->city?></h3>,
			<a href="" title="<?php echo $model->city_relation->province->province;?>"><?php echo $model->city_relation->province->province;?></a>, <?php echo $model->city_relation->province->country->country;?>
		</div>
	</div>
	<div class="area-info">
		<ul class="clearfix">
			<li <?php echo ($action == 'view') ? 'class="active"' : '';?>><a off_address="" class="profile" href="<?php echo Yii::app()->controller->createUrl('view',array('id'=>$model->city_id,'t'=>Utility::getUrlTitle($model->city_relation->city)))?>" title="Profile">Profile</a></li>
			<li <?php echo ($action == 'member') ? 'class="active"' : '';?>><a off_address="" class="agents" href="<?php echo Yii::app()->controller->createUrl('member',array('id'=>$model->city_id,'t'=>Utility::getUrlTitle($model->city_relation->city)))?>" title="<?php echo $model->users?> Agent">Agent [<?php echo $model->users?>]</a></li>
			<li <?php echo ($action == 'another') ? 'class="active"' : '';?>><a off_address="" class="anothers" href="<?php echo Yii::app()->controller->createUrl('another',array('id'=>$model->city_id,'t'=>Utility::getUrlTitle($model->city_relation->city)))?>" title="<?php echo $model->anothers?> Spesific Area">Spesific Area [<?php echo $model->anothers?>]</a></li>
			<li class="last"><a href="<?php echo Yii::app()->controller->createUrl('update',array('id'=>$model->id,'t'=>Utility::getUrlTitle($model->city_relation->city)))?>" title="Update Info">Update Info</a></li>
		</ul>
	</div>	
</div>

<div class="boxed">
	<div id="profile" class="box-contant">
		<?php echo $model->city_desc;?>
	</div>
	
	<div id="agents" class="box-contant">	
		<div class="list-view">
			<?php if($action == 'member') {
				echo '<div class="items">';
				echo $data;
				echo '</div>';
				$class = ($pager['itemCount'] == '0' || $pager['nextPage'] == '0') ? 'hide' : '';
				echo '<a class="pager '.$class.'" href="'.$nextPager.'" title="Readmore..">Readmore..</a>';
			} else {
				echo '<div class="items">';
				echo '<div class="loader"></div>';
				echo '</div>';
			}?>
		</div>
	</div>
	<div id="anothers" class="box-contant">
		<div class="list-view">		
			<?php if($action == 'another') {
				echo '<div class="items clearfix">';
				echo $data;
				echo '</div>';
				$class = ($pager['itemCount'] == '0' || $pager['nextPage'] == '0') ? 'hide' : '';
				echo '<a class="pager '.$class.'" href="'.$nextPager.'" title="Readmore..">Readmore..</a>';
			} else {
				echo '<div class="items clearfix">';
				echo '<div class="loader"></div>';
				echo '</div>';
			}?>
		</div>	
	</div>
</div>