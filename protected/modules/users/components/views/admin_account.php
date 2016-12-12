<?php
	if($model->photos != '')
		$images = Utility::getTimThumb($model->photos, 82, 82, 1);
	else
		$images = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/users/default.png', 82, 82, 1);
?>

<?php //begin.Information ?>
<div class="account">
	<?php //begin.Photo ?>
	<a off_address="" id="uplaod-image" class="photo" href="javascript:void(0);" title="<?php echo Yii::t('phrase', 'Change Photo').': '.Yii::app()->user->displayname;?>"><img src="<?php echo $images;?>" alt="<?php echo $model->photos != '' ? Yii::app()->user->displayname : 'Ommu Platform';?>"/></a>
	<div class="info">
		<?php echo Yii::t('phrase', 'Welcome');?>, <a href="<?php echo Yii::app()->createUrl('users/o/admin/edit')?>" title="<?php echo Yii::t('phrase', 'Edit Account').': '.Yii::app()->user->displayname;?>"><?php echo Yii::app()->user->displayname;?></a>
		<span><?php echo Yii::t('phrase', 'Last sign in');?> : <?php echo date('d-m-Y', strtotime(Yii::app()->user->lastlogin_date));?></span>
		<a class="signout" href="<?php echo Yii::app()->createUrl('site/logout');?>" title="<?php echo Yii::t('phrase', 'Logout').': '.Yii::app()->user->displayname;?>"><?php echo Yii::t('phrase', 'Logout');?></a>
	</div>
</div>
<?php //end.Information ?>
