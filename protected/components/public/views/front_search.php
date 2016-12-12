<?php
/**
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2013 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contect (+62)856-299-4114
 *
 */
?>
<?php //begin.Search ?>
<div class="search">
	<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
		'action'=>Yii::app()->createUrl('article/search/index'),
		'enableAjaxValidation'=>true,
		'method'=>'get',
		'id'=>'global-search',
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		)
	)); ?>
		<input type="text" name="search" placeholder="">
		<?php /*<input type="submit" value="Search">*/?>
	<?php $this->endWidget(); ?>
</div>
<?php //end.Search ?>
