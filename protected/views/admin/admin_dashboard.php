<?php
/**
 * @var $this LanguageController
 * @var $model OmmuLanguages
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array();
	//$this->widget('AdminDashboardStatistic');
?>

<div class="table">
	<div class="wall">
		<?php //begin.PostStatus ?>
		<?php echo $this->renderPartial('/wall/_form_dashboard', array(
			'model'=>$model,
		)); ?>
		
		<?php //begin.Status List-View ?>
		<div class="list-view">
			<div class="items">
				<?php echo $data;?>
			</div>
			<div class="paging clearfix">
				<span><?php echo $summaryPager;?></span>
				<?php if($pager[nextPage] != '0') {?>
					<a href="<?php echo $nextPager;?>" title="Readmore">Readmore</a>
				<?php }?>
			</div>
		</div>
	</div>
	<div class="recent">2</div>
</div>