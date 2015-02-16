<div class="sep">
	<div class="user">
		<?php
			if($data->user->photo_id == 0) {
				$images = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/users/default.png', 40, 40, 1);
			} else {
				$images = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/users/'.Yii::app()->user->id.'/'.$data->user->photo->photo, 40, 40, 1);
			}
		?>	
		<a href="javascript:void(0);" title="<?php echo $data->user->displayname;?>"><img src="<?php echo $images;?>" alt="<?php echo $data->user->displayname;?>"></a>
	</div>
	<div class="comment">
		<h4>
			<?php if($data->modified_date == '0000-00-00 00:00:00') {
				$date = Utility::dateFormat($data->creation_date, true);
			} else {
				$date = 'Edited: '.Utility::dateFormat($data->modified_date, true);
			}?>
			<a href="javascript:void(0);" title="<?php echo $data->user->displayname;?>"><?php echo $data->user->displayname;?></a> / 
			<?php echo $date;?>
		</h4>
		<?php echo $data->comment;?>
	</div>
	
</div>