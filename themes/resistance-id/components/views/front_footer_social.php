<?php if($model != null) {?>
<ul class="clearfix">
	<?php foreach($model as $key => $val) {
		if($val->cat->icons == '') {
			$images = Yii::app()->theme->baseUrl.'/images/social/default.png';
		} else {
			$images = Yii::app()->theme->baseUrl.'/images/social/'.$val->cat->icons;
		}
		if($val->cat_id == '10') {
			$url = 'ymsgr:sendim?'.$val->value;
			$target = '';
		} else {
			$url = $val->value;
			$target = 'target="_blank"';
		}
		echo '<li><a href="'.$url.'" title="'.Phrase::trans($val->cat->name, 2).'" '.$target.'><img src="'.$images.'" alt="'.Phrase::trans($val->cat->name, 2).'"></a></li>';
	}?>
</ul>
<?php }?>
