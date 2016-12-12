<?php if($model != null) {?>
	<ul>
	<?php 
	echo '<li><a href="'.Yii::app()->controller->createUrl('index').'" title="'.Yii::t('phrase', 'All').'">'.Yii::t('phrase', 'All').'</a></li>';
	foreach($model as $key => $val) {
		echo '<li><a href="'.Yii::app()->controller->createUrl('index', array('cat'=>$val->cat_id, 't'=>Utility::getUrlTitle(Phrase::trans($val->name,2)))).'" title="'.Phrase::trans($val->name,2).'">'.Phrase::trans($val->name,2).'</a></li>';
	}?>
	</ul>
<?php }?>
