<?php //begin.Inspiration ?>
<?php if($model != null) {
	$controller = strtolower(Yii::app()->controller->id);
?>
<div class="boxed" id="headline">
	<h2></h2>
	<div class="list-view">
		<?php foreach($model as $key => $val) {?>
		<div class="sep">
			<?php
			if($val->article_type == 1) {
				if($val->cover->media != '') {
					$media = Yii::app()->request->baseUrl.'/public/article/'.$val->article_id.'/'.$val->cover->media;
				} else {
					$media = Yii::app()->request->baseUrl.'/public/article/article_default.png';
				}
			} else if($val->article_type == 2) {
				$media = Yii::app()->request->baseUrl.'/public/article/article_default_video.png';
			} else if($val->article_type == 3) {
				$media = Yii::app()->request->baseUrl.'/public/article/article_default_audio.png';
			} else if($val->article_type == 4) {
				$media = Yii::app()->request->baseUrl.'/public/article/article_default_quote.png';
			}?>
			<a class="img" href="<?php echo Yii::app()->createUrl('article/'.$controller.'/view', array('id'=>$val->article_id, 't'=>Utility::getUrlTitle($val->title)));?>" title="<?php echo $val->title;?>"><img src="<?php echo Utility::getTimThumb($media, 400, 270, 1);?>"></a> 
			<div class="date">
				<?php echo Utility::dateFormat($val->creation_date, true);?>
				<?php //begin.Tools ?>
				<div class="tools">
					<?php if(Yii::app()->params['article_mod_comment'] == 1) {?><span class="comment"><?php echo $val->comment;?></span><?php }?>
					<?php if(Yii::app()->params['article_mod_view'] == 1) {?><span class="view"><?php echo $val->view;?></span><?php }?>
					<?php if(Yii::app()->params['article_mod_like'] == 1) {?><span class="like"><?php echo $val->likes;?></span><?php }?>
				</div>
				<?php //end.Tools ?>
			</div>
			<a class="title" href="<?php echo Yii::app()->createUrl('article/'.$controller.'/view', array('id'=>$val->article_id, 't'=>Utility::getUrlTitle($val->title)));?>" title="<?php echo $val->title;?>"><?php echo $val->title;?></a><br/>
			<p><?php echo Utility::shortText(Utility::hardDecode($val->body),300,' ...'); ?></p>
		</div>
		<?php }?>
	</div>
</div>
<?php }?>
<?php //end.Inspiration ?>