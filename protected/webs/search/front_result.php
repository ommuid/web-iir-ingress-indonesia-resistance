<?php
/**
 * @var $this SearchController
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */
 ?>
<div class="list-view">
	<?php if (!empty($results)) {?>
	<div class="items">
	<?php $pages = new CPagination(count($results));
		$currentPage = Yii::app()->getRequest()->getQuery('page', 1);
		$pages->pageSize = 10;

		$i = $currentPage * $pages->pageSize - $pages->pageSize;
		$end = $currentPage * $pages->pageSize;
		for($i=$i; $i<$end; $i++) {
		if($results[$i]->title != '') {?>
		<div class="sep <?php echo $results[$i]->media != '' ? 'images' : '';?>">
			<?php if($results[$i]->media != '') {?>
				<img src="<?php echo Utility::getTimThumb($results[$i]->media, 200, 120, 1);?>" alt="<?php echo CHtml::encode($results[$i]->title);?>">
			<?php }
			if($i == 0)
				echo CHtml::link(Utility::hardDecode(Utility::softDecode($results[$i]->title)), CHtml::encode($results[$i]->url), array('class'=>'title'));
			else
				echo CHtml::link($query->highlightMatches($results[$i]->title), CHtml::encode($results[$i]->url), array('class'=>'title'));
			echo $results[$i]->body != '' ? $query->highlightMatches(CHtml::encode(Utility::shortText($results[$i]->body,300))) : '';
			?>
			<div><i class="fa fa-link"></i><?php echo CHtml::link($query->highlightMatches(CHtml::encode($results[$i]->url)), CHtml::encode($results[$i]->url)); ?></div>
		</div>
		<?php }
		}?>
	</div>
	<div class="pager">
	<?php $this->widget('OLinkPager', array(
		'pages' => $pages,
		'header' => '',
	));?>
	</div>
		
	<?php } else {?>
		<div class="notifier-summary">
		<?php echo $_GET['keyword'];?> tidak ditemukan dalam pencarian
		</div>
	<?php }?>	
</div>