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
		'select' => 'online, site_type, site_title, construction_date, signup_inviteonly, general_include',
	));
	$construction = ($setting->online == 0 && date('Y-m-d', strtotime($setting->construction_date)) > date('Y-m-d')) ? 1 : 0 ;

	/**
	 * = Dialog Condition
	 * $construction = 1 (construction active)
	 */
	if($construction == 1) {
		if($this->pageGuest == false) {
			if($currentModuleAction == 'support/newsletter/subscribe' || (Yii::app()->request->isAjaxRequest && (($module == null || ($module != null && $module == 'pose')) && $currentAction == 'site/index'))) {
			} else {
				$this->redirect(Yii::app()->createUrl('support/newsletter/subscribe'));
			}
		}
		$dialogWidth = !empty($this->dialogWidth) ? ($this->dialogFixed == false ? $this->dialogWidth.'px' : '600px') : '900px';

	} else {
		if(Yii::app()->user->isGuest && $this->pageGuest == false && ($setting->site_type == 1 && $setting->signup_inviteonly != 0)) {
			if(($module == null || ($module != null && $module == 'pose')) && $currentAction == 'site/index') {
			} else {
				$this->redirect(Yii::app()->createUrl('site/login'));
			}
		}
		if($this->dialogDetail == true) {
			$dialogWidth = !empty($this->dialogWidth) ? ($this->dialogFixed == false ? $this->dialogWidth.'px' : '600px') : '900px';
		} else {
			$dialogWidth = '';
		}
	}
	
	$display = ($this->dialogDetail == true && !Yii::app()->request->isAjaxRequest) ? 'style="display: block;"' : '';
	
	/**
	 * = Slider condition
	 */	
	$slideDisplay = Quicknews::findPublish('find', 1, 'quicknews_id');
	$slideCondition = ($slideDisplay != null) ? 1 : 0;
	
	/**
	 * = pushState condition
	 */
	$title = CHtml::encode($this->pageTitle).' | '.$setting->site_title;
	$description = $this->pageDescription;
	$keywords = $this->pageMeta;
	$urlAddress = Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->request->requestUri;
	$apps = $this->dialogDetail == true ? ($this->dialogFixed == false ? 'apps' : 'module') : '';

	if(Yii::app()->request->isAjaxRequest && !isset($_GET['ajax'])) {
		if(Yii::app()->session['theme_active'] != Yii::app()->theme->name) {
			$return = array(
				'redirect' => $urlAddress,		
			);

		} else {
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
			$return['slide'] = $slideCondition;
			$return['script'] = $cs=Yii::app()->getClientScript()->getOmmuScript();
		}
		echo CJSON::encode($return);

	} else {
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/general.css');
		$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/form.css');
		$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/typography.css');
		$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/layout.css');
		$cs->registerCssFile(Yii::app()->request->baseUrl.'/externals/page/font-awesome.min.css');
		$cs->registerCssFile(Yii::app()->request->baseUrl.'/externals/content.css');
		$cs->registerCoreScript('jquery', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/plugin/less-1.7.4.min.js', CClientScript::POS_END);
		//$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/plugin/jquery.scrollTo.1.4.3.1-min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/plugin/jquery.ajaxuplaod-3.5.js', CClientScript::POS_END);
		if($slideDisplay != null) {
			$cs->registerScriptFile(Yii::app()->request->baseUrl.'/externals/quicknews/plugin/supersized.3.2.7.min.js', CClientScript::POS_END);
			$cs->registerScriptFile(Yii::app()->request->baseUrl.'/externals/quicknews/plugin/supersized.shutter.min.js', CClientScript::POS_END);
		}
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
			'slide'=>$slideCondition,
			'slideData'=>$slideDisplay != null ? Quicknews::getSlider('title, url, media') : '',
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
  <meta name="author" content="Ommu Platform (ommu@sudaryanto.me)" />
  <script type="text/javascript">
	var globals = '<?php echo CJSON::encode($jsAttribute);?>';
  </script>
  <?php echo $setting->general_include != '' ? $setting->general_include : ''?>
  <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl?>/favicon.ico" />
  <style type="text/css"></style>
 </head>
 <body <?php echo $this->dialogDetail == true ? 'style="overflow-y: hidden;"' : '';?>>

	<?php //begin.Loading ?>
	<div class="loading"></div>
	<?php //end.Loading ?>

	<?php //begin.Header ?>
	<header>

	</header>
	<?php //end.Header ?>

	<?php //begin.Dialog ?>
	<div class="dialog" id="<?php echo $apps;?>" <?php echo ($this->dialogDetail == true && empty($this->dialogWidth)) ? 'name="'.$dialogWidth.'" '.$display : '';?>>
		<div class="fixed">
			<div class="valign">
				<div class="dialog-box">
					<div class="content" id="<?php echo $dialogWidth;?>" name="dialog-wrapper"><?php echo ($this->dialogDetail == true && empty($this->dialogWidth)) ? $content : '';?></div>
				</div>
			</div>
		</div>
	</div>
	<?php //end.Dialog ?>

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

	<?php //begin.BodyContent ?>
	<div class="body">
		<?php //begin.Slider ?>
		<div id="slider" class="slider <?php echo $slideCondition == 0 ? 'hide' : '' ?>">
			<?php //begin.Thumbnail Navigation ?>
			<div id="prevthumb"></div>
			<div id="nextthumb"></div>
		
			<?php //begin.Time Bar ?>
			<div id="progress-back" class="load-item">
				<div id="progress-bar"></div>
			</div>

			<?php //Control Bar ?>
			<div id="controls-wrapper" class="load-item">
				<div id="controls">	
					<?php //Navigation ?>
					<ul id="slide-list"></ul>
				</div>
			</div>
		</div>
		<?php //end.Slider ?>

		<?php //begin.Content ?>
		<div class="wrapper"><?php echo $this->dialogDetail == false ? $content : '';?></div>
		<?php //end.Content ?>
	</div>
	<?php //end.BodyContent ?>

	<?php //begin.Footer ?>
	<footer class="clearfix">
		<?php $this->widget('FrontFooterCopyright'); ?>
	</footer>
	<?php //end.Footer ?>

	<?php $this->widget('FrontGoogleAnalytics'); ?>

 </body>
</html>
<?php }
}?>