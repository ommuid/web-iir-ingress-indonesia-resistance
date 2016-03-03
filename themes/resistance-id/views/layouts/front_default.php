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
<?php //echo $this->dialogDetail == true ? (empty($this->dialogWidth) ? 'class="boxed clearfix"' : 'class="clearfix"') : 'class="clearfix"';?>

<div id="<?php echo $class;?>" class="box-wrap <?php echo $this->adsSidebar == true ? 'ads-on' : '';?>">
	<?php if($this->adsSidebar == true) {?>
		<div class="content <?php echo $action;?>">
			<?php echo $content;?>
		</div>
		<div class="sidebar">
			1
		</div>
	<?php } else {?>
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
	<?php }?>
		
</div>

<?php $this->endContent(); ?>