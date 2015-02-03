<?php $this->beginContent('//layouts/default');
	Yii::import('webroot.themes.'.Yii::app()->theme->name.'.components.*');
	$module = strtolower(Yii::app()->controller->module->id);
	$controller = strtolower(Yii::app()->controller->id);
	$action = strtolower(Yii::app()->controller->action->id);
	$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
	$currentModule = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id);
	$currentModuleAction = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
	if($module == null) {
		if($controller == 'maintenance') {
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
	}
?>

	<div class="content" id="<?php echo $class;?>">
		<?php //begin.Title and Description ?>
		<h1><?php echo CHtml::encode($this->pageTitle); ?></h1>		
		<?php if(!empty($this->pageDescription)) {
			$pClass = isset($_GET['email']) ? 'class="notifier-on"' : '';
			echo '<p '.$pClass.'>'.$this->pageDescription.'</p>';
		}?>
		<?php //end.Title and Description ?>
		
		<?php echo $content;?>
		
		<?php //begin.Copyright ?>
		<div class="copyright">
			<?php $this->widget('FrontFooterCopyright'); ?>
		</div>
		<?php //end.Copyright ?>
	</div>

<?php $this->endContent(); ?>