<?php
/**
 * Articles (articles)
 * @var $this AdminController
 * @var $model Articles
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 20 October 2016, 10:14 WIB
 * @link https://github.com/ommu/Articles
 * @contact (+62)856-299-4114
 *
 */
?>

<?php if($data->media != '') {?>
<li>
	<?php if($data->cover == 0) {?>
		<a id="set-cover" href="<?php echo Yii::app()->controller->createUrl('o/media/setcover', array('id'=>$data->media_id,'hook'=>'admin'));?>" title="<?php echo Yii::t('phrase', 'Set Cover');?>"><?php echo Yii::t('phrase', 'Set Cover');?></a>
	<?php }?>
	<a id="set-delete" href="<?php echo Yii::app()->controller->createUrl('o/media/delete', array('id'=>$data->media_id,'hook'=>'admin'));?>" title="<?php echo Yii::t('phrase', 'Delete Photo');?>"><?php echo Yii::t('phrase', 'Delete Photo');?></a>
	<?php 
	$media = Yii::app()->request->baseUrl.'/public/article/'.$data->article_id.'/'.$data->media;?>
	<img src="<?php echo Utility::getTimThumb($media, 320, 250, 1);?>" alt="<?php echo $data->article->title;?>" />	
</li>
<?php }?>