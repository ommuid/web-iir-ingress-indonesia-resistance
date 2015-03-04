<?php
	if(Yii::app()->user->photo == 0) {
		$images = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/users/default.png', 36, 36, 1);
	} else {
		$images = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/users/'.Yii::app()->user->id.'/'.Yii::app()->user->photo, 36, 36, 1);
	}
?>

<div class="sep usermenu">
	<ul class="clearfix">
		<li>
			<a class="user-info clearfix" href="javascript:void(0);" title="<?php echo Yii::app()->user->username != '' ? Yii::app()->user->username : Yii::app()->user->displayname; ?>"><img src="<?php echo $images;?>" alt="<?php echo Yii::app()->user->photo != 0 ? Yii::app()->user->displayname : 'Ommu Platform';?>"/><h3><?php echo Yii::app()->user->username != '' ? Yii::app()->user->username : Yii::app()->user->displayname; ?></h3></a>
			<ul>
				<li><a href="" title="">My Profile</a></li>
				<li><a href="" title="">My Profile</a></li>
				<li><a href="" title="">My Profile</a></li>
				<li><a href="" title="">My Profile</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('site/logout')?>" title="Logout">Logout</a></li>
			</ul>
		</li>
		<li class="help"><a href="" title="Help">Help</a></li>
	</ul>
</div>