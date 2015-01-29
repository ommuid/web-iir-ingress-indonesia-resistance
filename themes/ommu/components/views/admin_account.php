<?php
	if($model->photo_id == 0) {
		$images = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/users/default.png', 82, 82, 1);
	} else {
		$images = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/users/'.Yii::app()->user->id.'/'.$model->photo->photo, 82, 82, 1);
	}
?>

<?php //begin.Information ?>
<div class="account">
	<?php //begin.Photo ?>
	<a off_address="" id="uplaod-image" class="photo" href="<?php echo Yii::app()->createUrl('users/photo/ajaxadd', array('type'=>'admin'));?>" title="<?php echo Phrase::trans(16223,1).': '.Yii::app()->user->displayname;?>"><img src="<?php echo $images;?>" alt="<?php echo $model->photo_id != 0 ? Yii::app()->user->displayname : 'Ommu Platform';?>"/></a>
	<div class="info">
		<?php echo Phrase::trans(248,0);?>, <a href="<?php echo Yii::app()->createUrl('users/admin/edit')?>" title="<?php echo Phrase::trans(16222,1).': '.Yii::app()->user->displayname;?>"><?php echo Yii::app()->user->displayname;?></a>
		<span><?php echo Phrase::trans(273,0);?> : <?php echo date('d-m-Y', strtotime($model->lastlogin_date));?></span>
		<a class="signout" href="<?php echo Yii::app()->createUrl('site/logout');?>" title="<?php echo Phrase::trans(274,0).': '.Yii::app()->user->displayname;?>"><?php echo Phrase::trans(274,0);?></a>
	</div>
</div>
<?php //end.Information ?>
