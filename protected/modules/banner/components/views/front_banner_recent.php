<?php 
	$cs = Yii::app()->getClientScript();
	$cs->registerCssFile(Yii::app()->request->baseUrl.'/externals/banner/responsiveslides.css');
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/externals/banner/plugin/responsiveslides.min.js', CClientScript::POS_END);
	$js=<<<EOP
		$("#rslides").responsiveSlides({
			//nav: true,
			pager: true,
		});
EOP;
	$cs->registerScript('banner', $js, CClientScript::POS_END);
	
if($model != null) {?>
<div class="banner top">
	<ul id="rslides" class="clearfix">
	<?php foreach($model as $key => $val) {
		$extension = pathinfo($val->media, PATHINFO_EXTENSION);
		if(!in_array($extension, array('bmp','gif','jpg','png')))
			$images = Yii::app()->request->baseUrl.'/public/banner/'.$val->media;
		else
			$images = Yii::app()->request->baseUrl.'/public/banner/'.$val->media;
		?>
		<li>
			<?php if($val->url != '-') {?>
				<a href="<?php echo Yii::app()->createUrl('banner/site/click', array('id'=>$val->banner_id, 't'=>Utility::getUrlTitle($val->title)))?>" title="<?php echo $val->title?>"><img src="<?php echo $images;?>" alt="<?php echo $val->title?>" /></a>
			<?php } else {?>
				<img src="<?php echo $images;?>" alt="<?php echo $val->title?>" />
			<?php }?>
		</li>
	<?php }?>
	</ul>
</div>
<?php }?>