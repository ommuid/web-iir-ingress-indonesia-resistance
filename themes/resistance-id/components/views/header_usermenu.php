<?php
if(!Yii::app()->user->isGuest) {
	if(Yii::app()->user->photo == 0) {
		$images = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/users/default.png', 30, 30, 1);
	} else {
		$images = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/users/'.Yii::app()->user->id.'/'.Yii::app()->user->photo, 30, 30, 1);
	}
	$username = Yii::app()->user->username != '' ? Yii::app()->user->username : Yii::app()->user->displayname;
	$imgname = Yii::app()->user->photo != 0 ? Yii::app()->user->displayname : 'Ommu Platform';
}
?>

<div class="sep usermenu">
	<ul class="clearfix">
		<li><a href="<?php echo Yii::app()->createUrl('page/view', array('id'=>'','t'=>''))?>" title="About">About</a></li>
		<li><a href="<?php echo Yii::app()->createUrl('article')?>" title="Blog">Blog</a></li>
		<li class="help"><a href="<?php echo Yii::app()->createUrl('faq')?>" title="Help">Help</a></li>
		<?php if(!Yii::app()->user->isGuest) {?>
		<li class="account">
			<a class="user-info clearfix" href="javascript:void(0);" title="<?php echo $username; ?>">
				<span><img src="<?php echo $images;?>" alt="<?php echo $imgname;?>"/></span>
				<h4><?php echo $username; ?></h4>
			</a>
			<ul>
				<li><a href="" title="">My Profile</a></li>
				<li><a href="" title="">My Profile</a></li>
				<li><a href="" title="">My Profile</a></li>
				<li><a href="" title="">My Profile</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('site/logout')?>" title="Logout">Logout</a></li>
			</ul>
		</li>
		<?php }?>
	</ul>
</div>