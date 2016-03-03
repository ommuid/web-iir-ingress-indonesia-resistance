<?php
/**
 * @var $this PluginphraseController
 * @var $model OmmuPluginPhrase
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Plugin Phrases'=>array('manage'),
		$model->phrase_id=>array('view','id'=>$model->phrase_id),
		'Update',
	);
?>

<?php echo $this->renderPartial('/plugin_phrase/_form', array(
	'model'=>$model,
	'language'=>$language,
)); ?>
