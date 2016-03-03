<?php
/**
 * Daop Provinces (daop-province)
 * @var $this ProvinceController * @var $model DaopProvince * @var $dataProvider CActiveDataProvider
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Daop Provinces',
	);
?>

<div class="boxed province">
	<div class="list-view">
		<div class="items">
			<?php echo $data;?>			
		</div>
		<a class="pager <?php echo ($pager['itemCount'] == '0' || $pager['nextPage'] == '0') ? 'hide' : '';?>" href="<?php echo $nextPage;?>" title="Next..">Next..</a>
	</div>
</div>
