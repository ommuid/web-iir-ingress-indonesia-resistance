<?php if($model != null) {?>
	<ul>
	<?php 
	echo '<li><a href="'.Yii::app()->controller->createUrl('index').'" title="'.Yii::t('phrase', 'All').'">'.Yii::t('phrase', 'All').'</a></li>';
	foreach($model as $key => $val) {
		echo '<li><a href="'.Yii::app()->controller->createUrl('index', array('cat'=>$val->cat_id, 'slug'=>Utility::getUrlTitle(Phrase::trans($val->name)))).'" title="'.Phrase::trans($val->name).'">'.Phrase::trans($val->name).'</a></li>';
	}?>
	</ul>
<?php }?>
