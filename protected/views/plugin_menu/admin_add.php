<?php
/**
 * @var $this PluginmenuController
 * @var $model OmmuPluginMenu
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Plugin Menus'=>array('manage'),
		'Create',
	);
?>

<?php echo $this->renderPartial('/plugin_menu/_form', array('model'=>$model)); ?>
