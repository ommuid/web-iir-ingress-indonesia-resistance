<div class="sep">
	<?php if($data->comment->user_id != 0) {
		$name = $data->comment->user->displayname;
		$email = $data->comment->user->email;
		$website = '';
	} else {
		$name = $data->comment->author->name;
		$email = $data->comment->author->email;
		$website = $data->comment->author->website;
	}?>
	<?php if($data->comment->user->photo_id != 0 || $data->comment->user->photo->photo != '') {
		$images = Yii::app()->request->baseUrl.'/public/users/'.$data->comment->user_id.'/'.$data->comment->user->photo->photo;
	} else {
		$images = Yii::app()->request->baseUrl.'/public/users/default.png';
	}?>
	<img class="img" src="<?php echo Utility::getTimThumb($images, 70, 70, 1);?>" alt="<?php echo $name;?>">
	<div class="info">
		<a href="mailto:<?php echo $email;?>" title="<?php echo $name;?>"><?php echo $name;?></a><br/>	
		<?php echo Utility::dateFormat($data->comment->creation_date, true);?>
	</div>
	<?php echo $data->comment->comment;?>
</div>