<?php
/**
 * Daop Anothers (daop-anothers)
 * @var $this AnotherController
 * @var $model DaopAnothers
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Daop Anothers'=>array('manage'),
		$model->another_id,
	);
?>

<?php //begin.Messages ?>
<?php
if(Yii::app()->user->hasFlash('success'))
	echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
?>
<?php //end.Messages ?>

<?php $this->widget('application.components.system.FDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'another_id',
		'status',
		'another_name',
		'another_desc',
		'another_cover',
		'another_photo',
		'country_id',
		'province_id',
		'city_id',
		'users',
		'creation_date',
		'creation_id',
		'modified_date',
		'modified_id',
	),
)); ?>

<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
