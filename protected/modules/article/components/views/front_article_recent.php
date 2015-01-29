<?php if($model != null) {
	$controller = strtolower(Yii::app()->controller->id);
?>
	<ul>
	<?php 
	foreach($model as $key => $val) {
		if($val->title != '') {
			$url = '<a class="bold" href="'.Yii::app()->createUrl('article/'.$controller.'/view', array('id'=>$val->article_id, 't'=>Utility::getUrlTitle($val->title))).'" title="'.$val->title.'">'.$val->title.'</a>';
		} else {
			$url = '';
		}
		if($val->article_type != '4') {
			$body = Utility::shortText($val->body,100);
		} else {
			$body = $val->body;
		}
		echo '<li>'.$url.$body.'</li>';
	}?>
	</ul>
<?php }?>
