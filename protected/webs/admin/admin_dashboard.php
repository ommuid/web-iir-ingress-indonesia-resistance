<?php
/**
 * @var $this AdminController
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array();
	//$this->widget('AdminDashboardStatistic');
	$cs = Yii::app()->getClientScript();
	$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/custom/custom_wall.js', CClientScript::POS_END);
?>

<div class="table">
	<div class="wall">
		administrator
		<?php //begin.PostStatus ?>
		<?php /*
		<?php echo $this->renderPartial('/wall/_form_dashboard', array(
			'model'=>$model,
		)); ?>
		
		<?php //begin.Status List-View ?>
		<div class="list-view">
			<div class="items wall">
				<?php echo $data;?>
			</div>
			<div class="paging clearfix">
				<span><?php echo $summaryPager;?></span>
				<?php if($pager[nextPage] != '0') {?>
					<a class="wall" href="<?php echo $nextPager;?>" title="Readmore">Readmore</a>
				<?php }?>
			</div>
		</div>
		*/?>
	</div>
	<div class="recent">
		sidebar
	</div>
</div>