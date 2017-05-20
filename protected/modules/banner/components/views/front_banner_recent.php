<?php 
	$cs = Yii::app()->getClientScript();
	$cs->registerCssFile($this->module->assetsUrl.'/responsiveslides.css');
	$cs->registerScriptFile($this->module->assetsUrl.'/plugin/responsiveslides.min.js', CClientScript::POS_END);
	//Yii::app()->getModule('banner')->getAssetsUrl;
	
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
		$extension = pathinfo($val->banner_filename, PATHINFO_EXTENSION);
		if(!in_array($extension, array('bmp','gif','jpg','png')))
			$images = Yii::app()->request->baseUrl.'/public/banner/'.$val->banner_filename;
		else
			$images = Yii::app()->request->baseUrl.'/public/banner/'.$val->banner_filename;
		?>
		<li>
			<?php if($val->url != '-') {?>
				<a href="<?php echo Yii::app()->createUrl('banner/site/click', array('id'=>$val->banner_id, 'slug'=>Utility::getUrlTitle($val->title)))?>" title="<?php echo $val->title?>"><img src="<?php echo $images;?>" alt="<?php echo $val->title?>" /></a>
			<?php } else {?>
				<img src="<?php echo $images;?>" alt="<?php echo $val->title?>" />
			<?php }?>
		</li>
	<?php }?>
	</ul>
</div>
<?php }?>