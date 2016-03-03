<?php if($model != null) {?>
	<ul>
	<?php 
	echo '<li><a href="'.Yii::app()->controller->createUrl('index').'" title="'.Phrase::trans(26051,1).'">'.Phrase::trans(26051,1).'</a></li>';
	foreach($model as $key => $val) {
		echo '<li><a href="'.Yii::app()->controller->createUrl('index', array('cat'=>$val->cat_id, 't'=>Utility::getUrlTitle(Phrase::trans($val->name,2)))).'" title="'.Phrase::trans($val->name,2).'">'.Phrase::trans($val->name,2).'</a></li>';
	}?>
	</ul>
<?php }?>
