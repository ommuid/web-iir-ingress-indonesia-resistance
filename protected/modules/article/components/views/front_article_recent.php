<?php if($model != null) {?>
<div class="box recent-news-article">
	<h3>Berita Terbaru</h3>
	<ul>
		<?php 
		$i=0;
		foreach($model as $key => $val) {
		$i++;
			$image = Yii::app()->request->baseUrl.'/public/article/article_default.png';
			$medias = $val->medias;
			if(!empty($medias)) {
				$media = $val->view->media_cover ? $val->view->media_cover : $medias[0]->media;
				$image = Yii::app()->request->baseUrl.'/public/article/'.$val->article_id.'/'.$media;
			}
			if($i == 1) {?>
				<li <?php echo !empty($medias) ? 'class="solid"' : '';?>>
					<a href="<?php echo Yii::app()->createUrl('article/site/view', array('id'=>$val->article_id, 'slug'=>Utility::getUrlTitle($val->title)))?>" title="<?php echo $val->title?>">
						<?php if(!empty($medias)) {?><img src="<?php echo Utility::getTimThumb($image, 230, 100, 1)?>" alt="<?php echo $val->title?>" /><?php }?>
						<?php echo $val->title?>
					</a>
				</li>
			<?php } else {?>
				<li><a href="<?php echo Yii::app()->createUrl('article/site/view', array('id'=>$val->article_id, 'slug'=>Utility::getUrlTitle($val->title)))?>" title="<?php echo $val->title?>"><?php echo $val->title?></a></li>
			<?php }
		}?>
	</ul>
</div>
<?php }?>