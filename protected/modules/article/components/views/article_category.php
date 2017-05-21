<?php
/**
 * @var $this ArticleCategoryComponent
 * @var $model ArticleCategory
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/mod-article
 * @contact (+62)856-299-4114
 *
 */

if($model != null) {?>
	<ul>
	<?php 
	echo '<li><a href="'.Yii::app()->controller->createUrl('index').'" title="'.Yii::t('phrase', 'All').'">'.Yii::t('phrase', 'All').'</a></li>';
	foreach($model as $key => $val) {
		echo '<li><a href="'.Yii::app()->controller->createUrl('index', array('cat'=>$val->cat_id, 'slug'=>Utility::getUrlTitle(Phrase::trans($val->name)))).'" title="'.Phrase::trans($val->name).'">'.Phrase::trans($val->name).'</a></li>';
	}?>
	</ul>
<?php }?>
