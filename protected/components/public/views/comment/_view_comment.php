<?php
/**
 * @var $this CommentController
 * @var $data ArticleComment */
?>

<div class="sep">
	<?php if($data->user_id != 0) {
		$name = $data->user->displayname;
		$email = $data->user->email;
		$website = '';
	} else {
		$name = $data->author->name;
		$email = $data->author->email;
		$website = $data->author->website;
	}?>
	<?php if($data->user->photo_id != 0 || $data->user->photo->photo != '') {
		$images = Yii::app()->request->baseUrl.'/public/users/'.$data->user_id.'/'.$data->user->photo->photo;
	} else {
		$images = Yii::app()->request->baseUrl.'/public/users/default.png';
	}?>
	<img class="img" src="<?php echo Utility::getTimThumb($images, 70, 70, 1);?>" alt="<?php echo $name;?>">
	<div class="info">
		<a href="mailto:<?php echo $email;?>" title="<?php echo $name;?>"><?php echo $name;?></a><br/>
		<?php echo Utility::dateFormat($data->creation_date, true);?>
	</div>
	<?php echo $data->comment;?>
	<div class="button">
		<a class="comment" off_address="" href="javascript:void(0);" title="<?php echo Phrase::trans(373,0)?>"><?php echo Phrase::trans(373,0)?> (<?php echo $data->reply;?>)</a>
		<a class="reply" off_address="" href="javascript:void(0);" title="<?php echo Phrase::trans(371,0)?>"><?php echo Phrase::trans(371,0)?></a>
	</div>
	<div id="reply">
		<?php 
		$criteria=new CDbCriteria;
		$criteria->condition = 'publish = :publish AND comment_id = :id';
		$criteria->params = array(
			':publish'=>1,
			':id'=>$data->comment_id,
		);
		$criteria->order = 'reply_id ASC';

		$reply = new CActiveDataProvider('OmmuCommentReply', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>5,
			),
		));		
		$this->widget('application.components.system.FListView', array(
			'dataProvider'=>$reply,
			'itemView'=>'/comment/_view_reply',
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
		)); ?>
		
		<?php if(!Yii::app()->user->isGuest) {?>
		<div class="form" name="post-on">
			<?php 
			$model=new OmmuComment;
			echo $this->render('/comment/_form_comment', array(
				'model'=>$model,
				'reply'=>true,
				'comment'=>$data->comment_id,
			)); ?>
		</div>
		<?php }?>
	</div>
</div>