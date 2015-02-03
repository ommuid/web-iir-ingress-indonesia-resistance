<?php
if(isset($_GET['protocol']) && $_GET['protocol'] == 'script') {
	echo $cs=Yii::app()->getClientScript()->getScripts();
	
} else {
	Yii::import('webroot.themes.'.Yii::app()->theme->name.'.components.*');
	$module = strtolower(Yii::app()->controller->module->id);
	$controller = strtolower(Yii::app()->controller->id);
	$action = strtolower(Yii::app()->controller->action->id);
	$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
	$currentModule = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id);
	$currentModuleAction = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);

	/**
	 * = Global condition
	 ** Construction condition
	 */
	$setting = OmmuSettings::model()->findByPk(1,array(
		'select' => 'online, site_type, site_title, construction_date',
	));
	$construction = ($setting->online == 0 && date('Y-m-d', strtotime($setting->construction_date)) > date('Y-m-d')) ? 1 : 0 ;

	/**
	 * = Dialog Condition
	 */
	if($this->dialogDetail == true) {
		$dialogWidth = !empty($this->dialogWidth) ? ($this->dialogFixed == false ? $this->dialogWidth.'px' : '600px') : '900px';
	} else {
		$dialogWidth = '';
	}
	
	$display = ($this->dialogDetail == true && !Yii::app()->request->isAjaxRequest) ? 'style="display: block;"' : '';
	
	/**
	 * = pushState condition
	 */
	$title = CHtml::encode($this->pageTitle).' | '.$setting->site_title;
	$description = $this->pageDescription;
	$keywords = $this->pageMeta;
	$urlAddress = Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->request->requestUri;
	$apps = $this->dialogDetail == true ? ($this->dialogFixed == false ? 'apps' : 'module') : '';

	if(Yii::app()->request->isAjaxRequest && !isset($_GET['ajax'])) {
		$page = $this->contentOther == true ? 1 : 0;
		$dialog = $this->dialogDetail == true ? (empty($this->dialogWidth) ? 1 : 2) : 0;		// 0 = static, 1 = dialog, 2 = notifier
		$header = /*$this->widget('FrontTopmenu', array(), true)*/'';
		
		if($this->contentOther == true) {
			$render = array(
				'content' => $content, 
				'other' => $this->contentAttribute,
			);
		} else {
			$render = $content;
		}
		$return = array(
			'title' => $title,
			'description' => $description,
			'keywords' => $keywords,
			'address' => $urlAddress,
			'dialogWidth' => $dialogWidth,			
		);
		$return['page'] = $page;
		$return['dialog'] = $dialog;
		$return['apps'] = $apps;
		$return['header'] = $this->dialogDetail != true ? $header : '';
		$return['render'] = $render;
		$return['script'] = $cs=Yii::app()->getClientScript()->getOmmuScript();
			
		echo CJSON::encode($return);

	} else {
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/general.css');
		$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/form.css');
		$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/typography.css');
		$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/layout.css');
		$cs->registerCoreScript('jquery', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/custom/custom.js', CClientScript::POS_END);
		
		//Javascript Attribute
		$jsAttribute = array(
			'baseUrl'=>BASEURL,
			'lastTitle'=>$title,
			'lastDescription'=>$description,
			'lastKeywords'=>$keywords,
			'lastUrl'=>$urlAddress,
			'dialogConstruction'=>$construction == 1 ? 1 : 0,
			'dialogGroundUrl'=>$this->dialogDetail == true ? ($this->dialogGroundUrl != '' ? $this->dialogGroundUrl : '') : '',
		);
		if($this->contentOther == true) {
			$jsAttribute['contentOther'] = $this->contentAttribute;
		}
	?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8" />
  <title><?php echo $title;?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="author" content="Ommu Platform (putra@ommu.co)" />
  <script type="text/javascript">
	var globals = '<?php echo CJSON::encode($jsAttribute);?>';
  </script>
  <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl?>/favicon.ico" />
  <style type="text/css"></style>
 </head>
 <body <?php echo $this->dialogDetail == true ? 'style="overflow-y: hidden;"' : '';?>>

	<?php //begin.Mainmenu ?>
	<div class="mainmenu" style="display: none;">
		<ul class="clearfix">
			<li><a href="" title=""></a></li>
			<li><a href="" title=""></a></li>
			<li><a href="" title=""></a></li>
			<li><a href="" title=""></a></li>
			<li><a href="" title=""></a></li>
		</ul>
	</div>
	<?php //end.Mainmenu ?>
	
	<div class="body">
		<?php //begin.Header ?>
		<header>
			1
			<ul class="clearfix">
				<li>
					<a href="" title=""></a>
					<ul class="clearfix">
						<li><a href="" title=""></a></li>
						<li><a href="" title=""></a></li>
						<li><a href="" title=""></a></li>
						<li><a href="" title=""></a></li>
						<li><a href="" title=""></a></li>
					</ul>				
				</li>
			</ul>
		</header>
		<?php //end.Header ?>
		
		<?php //begin.Content ?>
		<div class="wrapper">
			<?php echo $content;?>
		</div>
		<?php //end.Content ?>
	</div>
	
	<?php $this->widget('FrontGoogleAnalytics'); ?>

 </body>
</html>
<?php }
}?>