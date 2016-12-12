<?php
/**
 * Articles (articles)
 * @var $this AdminController
 * @var $model Articles
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Articles
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Articles'=>array('manage'),
		$model->title=>array('view','id'=>$model->article_id),
		'Update',
	);

	$url = Yii::app()->controller->createUrl('o/media/ajaxmanage', array('id'=>$model->article_id,'type'=>'admin'));
	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$.ajax({
		type: 'get',
		url: '$url',
		dataType: 'json',
		//data: { id: '$id' },
		success: function(render) {
			$('.horizontal-data #media-render #upload').before(render.data);
		}
	});
EOP;
	($model->article_type == 1 && $setting->media_limit != 1) ? $cs->registerScript('ajaxmanage', $js, CClientScript::POS_END) : '';
?>

<div class="form" <?php //echo ($model->article_type == 1 && $setting->media_limit != 1) ? 'name="post-on"' : ''; ?>>
	<?php echo $this->renderPartial('_form', array(
		'model'=>$model,
		'setting'=>$setting,
		'tag'=>$tag,
	)); ?>
</div>

<?php if($model->article_type == 1 && $setting->media_limit != 1) {?>
<div class="boxed mt-15">
	<h3><?php echo Yii::t('phrase', 'Article Photo'); ?></h3>
	<div class="clearfix horizontal-data" name="four">
		<ul id="media-render">
			<li id="upload" <?php echo (count(ArticleMedia::getPhoto($model->article_id)) == $setting->media_limit) ? 'class="hide"' : '' ?>>
				<a id="upload-gallery" href="<?php echo Yii::app()->controller->createUrl('o/media/ajaxadd', array('id'=>$model->article_id,'type'=>'admin'));?>" title="<?php echo Yii::t('phrase', 'Upload Photo'); ?>"><?php echo Yii::t('phrase', 'Upload Photo'); ?></a>
				<img src="<?php echo Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/article/article_default.png', 320, 250, 1);?>" alt="" />
			</li>
		</ul>
	</div>
</div>
<?php }?>