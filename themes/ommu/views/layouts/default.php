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
		'select' => 'site_title',
	));

	/**
	 * = Dialog Condition
	 */
	if($this->dialogDetail == true) {
		$dialogWidth = !empty($this->dialogWidth) ? $this->dialogWidth.'px' : '650px';
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

	if(Yii::app()->request->isAjaxRequest && !isset($_GET['ajax'])) {
		if((Yii::app()->session['theme_active'] != Yii::app()->theme->name) && ($action != 'manage')) {
			$return = array(
				'redirect' => $urlAddress,		
			);

		} else {
			$page = $this->contentOther == true ? 1 : 0;
			$dialog = $this->dialogDetail == true ? (empty($this->dialogWidth) ? 1 : 2) : 0;		// 0 = static, 1 = dialog, 2 = notifier
			$header = $this->widget('AdminMenu', array(), true);
			
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
			$return['header'] = $this->dialogDetail != true ? $header : '';
			$return['render'] = $render;
			$return['script'] = $cs=Yii::app()->getClientScript()->getOmmuScript();
		}
		echo CJSON::encode($return);

	} else {
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/general.css');
		$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/form.css');
		$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/typography.css');
		$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/layout.css');
		$cs->registerCoreScript('jquery', CClientScript::POS_END);
		if ($currentAction != 'site/login') {
			$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/plugin/jquery.scrollTo.1.4.3.1-min.js', CClientScript::POS_END);
			$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/plugin/jquery.ajaxuplaod-3.5.js', CClientScript::POS_END);
		}
		$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/custom/custom.js', CClientScript::POS_END);
	?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8" />
  <title><?php echo $title;?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="author" content="Ommu Platform (ommu@sudaryanto.me)" />
  <script type="text/javascript">
	var baseUrl = '<?php echo BASEURL;?>';
	var lastTitle = '<?php echo $title;?>';
	var lastDescription = '<?php echo $description;?>';
	var lastKeywords = '<?php echo $keywords;?>';
	var lastUrl = '<?php echo $urlAddress;?>';
	//javascript attribute
	var dialogGroundUrl = '<?php echo $this->dialogDetail == true ? ($this->dialogGroundUrl != '' ? $this->dialogGroundUrl : '') : '';?>';
  </script>
  <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl?>/favicon.ico" />
  <style type="text/css"></style>
 </head>
 <body <?php echo $this->dialogDetail == true ? 'style="overflow-y: hidden;"' : '';?>>

<?php 
if ($currentAction == 'site/login') {
//if(Yii::app()->user->isGuest) {?>
	<?php //begin.Notifier ?>
	<div class="login notifier" <?php echo ($this->dialogDetail == true && !empty($this->dialogWidth)) ? 'name="'.$dialogWidth.'" '.$display : '';?>>
		<div class="fixed">
			<div class="valign">
				<div class="dialog-box">
					<img src="<?php echo Yii::app()->theme->baseUrl;?>/images/resource/logo_ommu_large.png" alt="">
					<div class="content" id="<?php echo $dialogWidth;?>" name="notifier-wrapper"><?php echo ($this->dialogDetail == true && !empty($this->dialogWidth)) ? $content : '';?></div>
				</div>
			</div>
		</div>
	</div>
	<?php //end.Notifier ?>

<?php } else { ?> 

	<?php //begin.Header ?>
	<header class="clearfix">
		<?php //begin.Flag and Language ?>
		<div class="flag learfix">
			<?php
			if(!empty($_GET)) {
				$attrEn = array_merge($_GET, array('lang'=>'en'));
				$attrId = array_merge($_GET, array('lang'=>'id'));
			} else {
				$attrEn = array('lang'=>'en');
				$attrId = array('lang'=>'id');
			}
			if($module == 'null') {
				$urlEn = Yii::app()->createUrl($controller.'/'.$action, $attrEn);
				$urlId = Yii::app()->createUrl($controller.'/'.$action, $attrId);
			} else {
				$urlEn = Yii::app()->createUrl($module.'/'.$controller.'/'.$action, $attrEn);
				$urlId = Yii::app()->createUrl($module.'/'.$controller.'/'.$action, $attrId);
			}
			?>
			<a off_address="" href="<?php echo $urlEn;?>" title="English"><img src="<?php echo Yii::app()->theme->baseUrl;?>/images/icons/flag_en.png" /></a>
			<a off_address="" href="<?php echo $urlId;?>" title="Indonesia"><img src="<?php echo Yii::app()->theme->baseUrl;?>/images/icons/flag_id.png" /></a>
		</div>
		<?php //end.Flag and Language ?>
		
		<?php //begin.Loading ?>
		<div class="loading"><img src="<?php echo Yii::app()->theme->baseUrl;?>/images/icons/ajax_loader.gif" /><span>Loading...</span></div>
		<?php //begin.Success ?>
		<div class="message"></div>
	</header>
	<?php //end.Header ?>
	
	<?php //begin.Notifier ?>
	<div class="notifier" <?php echo ($this->dialogDetail == true && !empty($this->dialogWidth)) ? 'name="'.$dialogWidth.'" '.$display : '';?>>
		<div class="fixed">
			<div class="valign">
				<div class="dialog-box">
					<div class="content" id="<?php echo $dialogWidth;?>" name="notifier-wrapper"><?php echo ($this->dialogDetail == true && !empty($this->dialogWidth)) ? $content : '';?></div>
				</div>
			</div>
		</div>
	</div>
	<?php //end.Notifier ?>

	<?php //begin.Dialog ?>
	<div class="dialog" <?php echo ($this->dialogDetail == true && empty($this->dialogWidth)) ? 'name="'.$dialogWidth.'" '.$display : '';?>>
		<div class="fixed">
			<div class="valign">
				<div class="dialog-box">
					<div class="content" id="<?php echo $dialogWidth;?>" name="dialog-wrapper"><?php echo ($this->dialogDetail == true && empty($this->dialogWidth)) ? $content : '';?></div>
				</div>
			</div>
		</div>
	</div>
	<?php //end.Dialog ?>

	<?php //begin.BodyContent ?>
	<div class="body clearfix">
		<?php //begin.Sidebar ?>
		<div class="sidebar">
			<div class="table clearfix">
				<?php //begin.Information ?>
				<?php $this->widget('AdminAccount'); ?>
				<?php //end.Information ?>

				<?php //begin.Menu ?>
				<div class="menu clearfix">
					<?php $this->widget('AdminMenu'); ?>
				</div>
				<?php //end.Menu ?>
			</div>
		</div>
		<?php //end.Sidebar ?>

		<?php //begin.Content ?>
		<div class="content">
			<div class="wrapper">
				<?php echo $this->dialogDetail == false ? $content : '';?>
			</div>
		</div>
		<?php //end.Content ?>
	</div>
	<?php //end.BodyContent ?>
	
	<?php //begin.Footer ?>
	<footer class="clearfix">
		<?php $this->widget('AdminFooterCopyright'); ?>
	</footer>
	<?php //end.Footer ?>
<?php }?>
	<?php $this->widget('FrontGoogleAnalytics'); ?>

 </body>
</html>

<?php }
}?>