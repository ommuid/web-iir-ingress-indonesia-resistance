<?php $this->beginContent('//layouts/default');
	Yii::import('webroot.themes.'.Yii::app()->theme->name.'.components.*');
	$module = strtolower(Yii::app()->controller->module->id);
	$controller = strtolower(Yii::app()->controller->id);
	$action = strtolower(Yii::app()->controller->action->id);
	$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
	$currentModule = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id);
	$currentModuleAction = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
	if($module == null) {
		if($controller == 'site') {
			if($action == 'index') {
				$class = 'main';
			} else if($action == 'login') {
				$class = 'login';
			} else {
				$class = $action;
			}
		} else {
			$class = $controller;
		}
	} else {
		if($controller == 'site') {
			$class = $module;
		} else {
			$class = $module.'-'.$controller;
		}
	}
?>

	<?php if($this->dialogDetail == true && $this->dialogFixed == true) {?>
	<?php //begin.Logo and Dialog Menu ?>
		<?php //begin.Dialog Header Menu ?>
		<div class="header">
			<div class="left">
				
			</div>
			<div class="right">
				<a href="<?php echo Yii::app()->createUrl('page/view', array('id'=>1, 't'=>Utility::getUrlTitle(Phrase::trans(1501,2))))?>" title="<?php echo Phrase::trans(1501,2);?>"><?php echo Phrase::trans(1501,2);?></a>/
				<a href="<?php echo Yii::app()->createUrl('support/contact/index')?>" title="<?php echo Phrase::trans(23038,1);?>"><?php echo Phrase::trans(23038,1);?></a>/
				<a href="<?php echo Yii::app()->createUrl('support/contact/feedback')?>" title="<?php echo Phrase::trans(23102,1);?>"><?php echo Phrase::trans(23102,1);?></a>
			</div>			
		</div>
		<?php //end.Dialog Header Menu ?>
		<?php //begin.Dialog Footer Menu ?>
		<div class="footer clearfix">
			<div class="right">
				<a href="<?php echo Yii::app()->createUrl('page/view', array('id'=>2, 't'=>Utility::getUrlTitle(Phrase::trans(1503,2))))?>" title="<?php echo Phrase::trans(1503,2);?>"><?php echo Phrase::trans(1503,2);?></a>&#8226;
				<a href="<?php echo Yii::app()->createUrl('page/view', array('id'=>3, 't'=>Utility::getUrlTitle(Phrase::trans(1505,2))))?>" title="<?php echo Phrase::trans(1505,2);?>"><?php echo Phrase::trans(1505,2);?></a>&#8226;
				<a href="<?php echo Yii::app()->createUrl('faq/site/index')?>" title="<?php echo Phrase::trans(11000,1);?>"><?php echo Phrase::trans(11000,1);?></a>
			</div>
			<div class="left">
				<a href="<?php echo Yii::app()->createUrl('site/index')?>" title="Nirwasita">Nirwasita</a> &copy; 2013
			</div>
		</div>
		<?php //end.Dialog Footer Menu ?>
	<?php }?>
	<?php //end.Logo and Dialog Menu ?>
	
	<?php if(!Yii::app()->user->isGuest) {?>
		<?php //begin.Sidebar ?>
		<div id="sidebar">
			21
		</div>
		<?php //end.Sidebar ?>
		
		<?php //begin.Content ?>
		<div id="content">
			22
		</div>
		<?php //end.Content ?>
	<?php } else {?>
	<?php }?>
	
	<?php /*
	<div id="<?php echo $class;?>" <?php echo $this->dialogDetail == true ? (empty($this->dialogWidth) ? 'class="boxed clearfix"' : 'class="clearfix"') : 'class="clearfix"';?>>

		<?php if($this->dialogDetail == true) {
			if(!empty($this->dialogWidth)) {?>
				<?php //begin.Notifier Header ?>
				<div class="dialog-header">
					<?php echo CHtml::encode($this->pageTitle); ?>
				</div>
				<?php echo $content?>

			<?php } else {
				if($this->dialogFixed == true) {?>
					<?php //begin.Dialog Header?>
					<h1><?php echo CHtml::encode($this->pageTitle); ?></h1>
					<?php if(!empty($this->pageDescription)) {?>
					<div class="intro">
						<?php echo $this->pageDescription;?>
					</div>
					<?php }
					// begin.render Content
					echo $content;
					?>
					
					<?php //begin.Button Close ?>
					<div class="button">
						<?php $this->widget(
							'FrontOtherDialogClosed', array(
							'links' => Yii::app()->controller->dialogFixedClosed,
						)); ?>
					</div>
					<?php //end.Button Close ?>
				<?php } else {
					echo $content;
				}
			}			
		} else {
			echo $content;
		}?>
	</div>

	<?php //begin.Copyright ?>
	<?php if($this->dialogDetail == true && $this->dialogFixed == false && empty($this->dialogWidth)) {?>
	<div class="copyright clearfix">
		<div class="right">
			<a href="<?php echo Yii::app()->createUrl('page/view', array('id'=>1, 't'=>Utility::getUrlTitle(Phrase::trans(1501,2))))?>" title="<?php echo Phrase::trans(1501,2);?>"><?php echo Phrase::trans(1501,2);?></a>&#8226;
			<a href="<?php echo Yii::app()->createUrl('page/view', array('id'=>2, 't'=>Utility::getUrlTitle(Phrase::trans(1503,2))))?>" title="<?php echo Phrase::trans(1503,2);?>"><?php echo Phrase::trans(1503,2);?></a>&#8226;
			<a href="<?php echo Yii::app()->createUrl('page/view', array('id'=>3, 't'=>Utility::getUrlTitle(Phrase::trans(1505,2))))?>" title="<?php echo Phrase::trans(1505,2);?>"><?php echo Phrase::trans(1505,2);?></a>&#8226;
			<a href="<?php echo Yii::app()->createUrl('faq/site/index')?>" title="<?php echo Phrase::trans(11000,1);?>"><?php echo Phrase::trans(11000,1);?></a>&#8226;
			<a href="<?php echo Yii::app()->createUrl('support/contact/index')?>" title="<?php echo Phrase::trans(23038,1);?>"><?php echo Phrase::trans(23038,1);?></a>&#8226;
			<a href="<?php echo Yii::app()->createUrl('support/contact/feedback')?>" title="<?php echo Phrase::trans(23102,1);?>"><?php echo Phrase::trans(23102,1);?></a>
		</div>
		<div class="left">
			<a href="<?php echo Yii::app()->createUrl('site/index')?>" title="Nirwasita">Nirwasita</a> &copy; 2013
		</div>
	</div>
	<?php }?>
	<?php //end.Copyright ?>
	*/?>

<?php $this->endContent(); ?>