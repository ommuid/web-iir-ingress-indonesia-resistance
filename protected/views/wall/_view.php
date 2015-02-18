
<?php
/**
 * Ommu Walls (ommu-walls)
 * @var $this WallController * @var $data OmmuWalls *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
 
/* Get Comment */
$criteria=new CDbCriteria; 
$criteria->condition = 'publish = :publish AND parent_id = :parent AND wall_id = :wall'; 
$criteria->params = array(
	':publish'=>1,
	':parent'=>0,
	':wall'=>$data->wall_id,
); 
$criteria->order = 'creation_date ASC'; 

$dataProvider = new CActiveDataProvider('OmmuWallComment', array( 
	'criteria'=>$criteria, 
	'pagination'=>array( 
		'pageSize'=>5, 
	), 
)); 
		
$val = '';
$comment = $dataProvider->getData();
if(!empty($comment)) {
	foreach($comment as $key => $item) {
		$val .= Utility::otherDecode($this->renderPartial('/wall_comment/_view', array('data'=>$item), true, false));
	}
}
$commentPager = OFunction::getDataProviderPager($dataProvider);
$commentNextPager = $commentPager['nextPage'] != 0 ? Yii::app()->createUrl('wallcomment/get', array('id'=>$data->wall_id, $commentPager['pageVar']=>$commentPager['nextPage'])) : 0;
?>

<div class="sep comment-show" id="wall-<?php echo $data->wall_id;?>">
	<div class="user">
		<?php
			if($data->user->photo_id == 0) {
				$images = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/users/default.png', 60, 60, 1);
			} else {
				$images = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/users/'.Yii::app()->user->id.'/'.$data->user->photo->photo, 60, 60, 1);
			}
		?>	
		<a href="javascript:void(0);" title="<?php echo $data->user->displayname;?>"><img src="<?php echo $images;?>" alt="<?php echo $data->user->displayname;?>"></a>
	</div>
	<div class="status">
		<?php if($data->wall_media != '') {
			echo $data->wall_media;
		}?>
		<h3>
			<?php if($data->modified_date == '0000-00-00 00:00:00') {
				$date = Utility::dateFormat($data->creation_date, true);
			} else {
				$date = 'Edited: '.Utility::dateFormat($data->modified_date, true);
			}?>
			<a href="javascript:void(0);" title="<?php echo $data->user->displayname;?>"><?php echo $data->user->displayname;?></a> / 
			<?php echo $date;?>
		</h3>
		
		<?php echo $data->wall_status;?>
		<div class="meta">
			<a class="likes" href="javascript:void(0);" title="<?php echo $data->likes.' Like'?>"><?php echo $data->likes.' Like'?></a> | 
			<a class="comment" href="javascript:void(0);" title="<?php echo $data->comments.' Comment'?>"><?php echo $data->comments.' Comment'?></a>
		</div>
		<?php //begin.Comment ?>
		<div class="list-view">
			<div class="items comment">
				<?php echo $val;?>
			</div>
			<?php if($commentPager[nextPage] != '0') {?>
			<div class="paging clearfix">
				<a class="comment" href="<?php echo $commentNextPager;?>" title="Readmore Comment">Readmore Comment</a>
			</div>
			<?php }?>
			<div class="comment-post">
				<?php $user = Users::model()->findByPk(Yii::app()->user->id, array(
					'select' => 'photo_id',
				));
				if($user->photo_id == 0) {
					$userImages = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/users/default.png', 40, 40, 1);
				} else {
					$userImages = Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/users/'.Yii::app()->user->id.'/'.$model->photo->photo, 40, 40, 1);
				}?>
				<a href="javascript:void(0);" title="<?php echo Yii::app()->user->displayname;?>"><img src="<?php echo $userImages;?>" alt="<?php echo Yii::app()->user->displayname;?>"></a>
				comment post
			</div>
		</div>
	</div>	
</div>