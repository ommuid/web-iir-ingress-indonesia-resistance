<?php //begin.Hot Content ?>
<?php if($model != null) {
	$controller = strtolower(Yii::app()->controller->id);
?>
<div class="boxed" id="hottest">
	<h2>Terpanas</h2>
	<div class="box">
		<ul>
		<?php 
		foreach($model as $key => $val) {?>
			<li><a href="<?php echo Yii::app()->createUrl('article/'.$controller.'/view', array('id'=>$val->article_id, 't'=>Utility::getUrlTitle($val->title)))?>" title="<?php echo $val->title;?>"><?php echo $val->title;?></a></li>
		<?php }?>
		</ul>
	</div>
</div>
<?php }?>
<?php //end.Hot Content ?>