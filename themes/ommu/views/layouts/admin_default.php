<?php $this->beginContent('//layouts/default');
	Yii::import('webroot.themes.'.Yii::app()->theme->name.'.components.*');
	$module = strtolower(Yii::app()->controller->module->id);
	$controller = strtolower(Yii::app()->controller->id);
	$action = strtolower(Yii::app()->controller->action->id);
	$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
	$currentModule = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id);
	$currentModuleAction = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
	if($module == null) {
		if($currentAction == 'site/login') {
			$class = 'login';
		} else {
			$class = $controller;
		}
	} else {
		if($controller == 'admin') {
			$class = $module;
		} else {
			$class = $module.'-'.$controller;
		}
	}
?>
	
	<div id="<?php echo $class;?>" <?php echo $this->dialogDetail == true ? (!empty($this->dialogWidth) ? 'class="boxed"' : 'class="clearfix"') : 'class="clearfix"';?>>
		<?php if($this->dialogDetail == false) {
			if ($currentAction != 'site/login') {?>
			<?php //begin.Title ?>
			<h1 class="small"><?php echo CHtml::encode($this->pageTitle); ?></h1>
			<?php echo $this->pageDescription != OmmuSettings::getInfo('site_description') ? '<p class="intro">'.$this->pageDescription.'</p>' : '';?>
			<?php //end.Title ?>

			<?php //begin.Content Menu ?>
			<div class="contentmenu clearfix">
				<?php $this->widget('AdminContentMenu'); ?>
				<?php $this->widget('application.components.system.CMenu', array(
					'items'=>$this->menu,
					'htmlOptions'=>array('class'=>'gridmenu clearfix'),
				)); ?>
			</div>
			<?php //end.Content Menu ?>
		<?php }
		}
		
		//If Dialog
		if($this->dialogDetail == true && !empty($this->dialogWidth)) {?>
			<?php //begin.Dialog Header ?>
			<div class="dialog-header">
				<h1><?php echo CHtml::encode($this->pageTitle); ?></h1>
			</div>
			<?php //end.Dialog Header ?>
		<?php }?>
		
		<?php echo $content; ?>
	</div>

<?php $this->endContent(); ?>