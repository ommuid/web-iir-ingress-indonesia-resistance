<?php
/**
 * Support Feedback Views (support-feedback-view)
 * @var $this ViewsController
 * @var $model SupportFeedbackView
 * @var $form CActiveForm
 * version: 0.2.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 11 May 2017, 23:13 WIB
 * @link https://github.com/ommu/Support
 * @contact (+62)856-299-4114
 *
 */
?>

<?php echo CHtml::beginForm(Yii::app()->createUrl($this->route), 'get', array(
	'name' => 'gridoption',
));
$columns   = array();
$exception = array('id');
foreach($model->metaData->columns as $key => $val) {
	if(!in_array($key, $exception)) {
		$columns[$key] = $key;
	}
}
?>
<ul>
	<?php foreach($columns as $val): ?>
	<li>
		<?php echo CHtml::checkBox('GridColumn['.$val.']'); ?>
		<?php echo CHtml::label($val, 'GridColumn_'.$val); ?>
	</li>
	<?php endforeach; ?>
</ul>
<?php echo CHtml::endForm(); ?>
