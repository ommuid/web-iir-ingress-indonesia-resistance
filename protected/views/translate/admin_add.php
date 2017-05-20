<?php
/**
 * Ommu System Phrase (ommu-system-phrase)
 * @var $this TranslateController
 * @var $model OmmuSystemPhrase
 * @var $form CActiveForm
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Ommu System Phrases'=>array('manage'),
		'Create',
	);
?>

<div class="form">
	<?php echo $this->renderPartial('_form', array(
		'model'=>$model,
		'language'=>$language,
	)); ?>
</div>
