<?php //begin.Flag and Language ?>
<?php 
$action = strtolower(Yii::app()->controller->action->id);
if($model != null) {?>
<div class="flag learfix">
	<?php foreach($model as $key => $val) {
		$flag = 'flag_en.png';
		if($val->code == 'id')
			$flag = 'flag_id.png';
		?>
	<a off_address="" href="<?php echo Yii::app()->controller->createUrl($action, array('lang'=>$val->code));?>" title="<?php echo $val->name;?>"><img src="<?php echo Yii::app()->theme->baseUrl;?>/images/icons/<?php echo $flag;?>" /></a>
	<?php }?>
</div>
<?php }?>
<?php //end.Flag and Language ?>