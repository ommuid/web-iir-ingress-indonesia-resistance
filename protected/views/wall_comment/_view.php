<?php
/**
 * Ommu Wall Comments (ommu-wall-comment)
 * @var $this WallcommentController
 * @var $model OmmuWallComment
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2015 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */
?>
<div class="sep">
	<div class="user">
		<?php
		$image = Yii::app()->request->baseUrl.'/public/users/default.png';
		if($data->user->photos)
			$image = Yii::app()->request->baseUrl.'/public/users/'.Yii::app()->user->id.'/'.$data->user->photos;?>
		<a href="javascript:void(0);" title="<?php echo $data->user->displayname;?>"><img src="<?php echo $image;?>" alt="<?php echo $data->user->displayname;?>"></a>
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