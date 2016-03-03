<div id="comment" class="clearfix">
	<h3></h3>
	<?php 
	//if($comment->getTotalItemCount() != 0 ) {
		$this->widget('application.components.system.FListView', array(
			'dataProvider'=>$comment,
			'itemView'=>'/comment/_view_comment',
			'pager' => array(
				'header' => '',
				'firstPageLabel' => '<<',
				'prevPageLabel'  => '<',
				'nextPageLabel'  => '>',
				'lastPageLabel'  => '>>',
			), 
			'summaryText' => '',
			'itemsCssClass' => 'items clearfix',
			'pagerCssClass'=>'pager clearfix',
		));
	//}?>
	<?php if(!Yii::app()->user->isGuest) {?>
	<div class="form" name="post-on">
		<?php $this->render('/comment/_form_comment', array(
			'model'=>$model,
		)); ?>
	</div>
	<?php }?>
</div>