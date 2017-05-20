<?php
	$image = $this->imageDefault;
	if($model != null) {
		$userPath = "public/users/".Yii::app()->user->id;
		if($model->photos != '' && file_exists($userPath.'/'.$model->photos))
			$image = Yii::app()->request->baseUrl.'/'.$userPath.'/'.$model->photos;
	}
?>

<?php //begin.Information ?>
<div class="account">
	<?php //begin.Photo ?>
	<a off_address="" id="uplaod-image" class="photo" href="<?php echo Yii::app()->createUrl('users/o/admin/photo');?>" title="<?php echo Yii::t('phrase', 'Change Photo').': '.Yii::app()->user->displayname;?>"><img src="<?php echo Utility::getTimThumb($image, 82, 82, 1);?>" alt="<?php echo $model->photos != '' ? Yii::app()->user->displayname : 'Ommu Platform';?>"/></a>
	<div class="info">
		<?php echo Yii::t('phrase', 'Welcome');?>, <a href="<?php echo Yii::app()->createUrl('users/o/admin/edit')?>" title="<?php echo Yii::t('phrase', 'Edit Account').': '.Yii::app()->user->displayname;?>"><?php echo Yii::app()->user->displayname;?></a>
		<span><?php echo Yii::t('phrase', 'Last sign in');?> : <?php echo Utility::dateFormat($model->lastlogin_date);?></span>
		<a class="signout" href="<?php echo Yii::app()->createUrl('site/logout');?>" title="<?php echo Yii::t('phrase', 'Logout').': '.Yii::app()->user->displayname;?>"><?php echo Yii::t('phrase', 'Logout');?></a>
	</div>
</div>
<?php //end.Information ?>
