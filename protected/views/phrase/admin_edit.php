<?php
/**
 * @var $this PhraseController
 * @var $model OmmuPhrases
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu Phrases'=>array('manage'),
		$model->phrase_id=>array('view','id'=>$model->phrase_id),
		'Update',
	);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'language'=>$language,
)); ?>