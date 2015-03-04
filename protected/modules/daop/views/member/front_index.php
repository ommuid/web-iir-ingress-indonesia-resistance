<?php
/**
 * Daop Users (daop-users)
 * @var $this MemberController * @var $model DaopUsers * @var $dataProvider CActiveDataProvider
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Daop Users',
	);
	$cs = Yii::app()->getClientScript();
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/externals/daop/custom_daop.js', CClientScript::POS_END);
?>

<?php //begin.City DaOps ?>
<?php 
	$criteria=new CDbCriteria;
	$criteria->condition = 'user_id = :id';
	$criteria->params = array(
		':id'=>Yii::app()->user->id,
	);
	$criteria->order = 'creation_date DESC';

	$dataProvider = new CActiveDataProvider('DaopUsers', array(
		'criteria'=>$criteria,
		'pagination'=>array(
			'pageSize'=>7,
		),
	));
	
	$data = '';
	$daops = $dataProvider->getData();
	if(!empty($daops)) {
		foreach($daops as $key => $item) {
			$data .= Utility::otherDecode($this->renderPartial('_view', array('data'=>$item), true, false));
		}
	}
	$pager = OFunction::getDataProviderPager($dataProvider);
	if($pager[nextPage] != '0') {
		$summaryPager = '[1-'.($pager[currentPage]*$pager[pageSize]).' of '.$pager[itemCount].']';
	} else {
		$summaryPager = '[1-'.$pager[itemCount].' of '.$pager[itemCount].']';
	}
	$nextPager = $pager['nextPage'] != 0 ? Yii::app()->controller->createUrl('get', array($pager['pageVar']=>$pager['nextPage'])) : 0;
?>
<div class="boxed">
	<div class="title clearfix">
		<h2 class="city">Citys</h2>
		<a class="plus" href="javascript:void(0);" title="Add Operation Area">Add City Operation</a>
	</div>
	
	<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
		'id'=>'daop-users-form',
		'action'=>Yii::app()->controller->createUrl('post'),
		'enableAjaxValidation'=>true,
		//'htmlOptions' => array('enctype' => 'multipart/form-data')
	)); ?>
	<fieldset>
		<?php 
		//echo $form->textField($model,'city_input',array('class'=>'span-5','placeholder'=>'Kota atau Kabupaten'));
		$url = Yii::app()->controller->createUrl('citypost');
		$userID = Yii::app()->user->id;
		$cityID = 'DaopUsers_city_input';
		$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'model' => $model,
			'attribute' => 'city_input',
			'source' => Yii::app()->controller->createUrl('citysuggest'),
			'options' => array(
				//'delay '=> 50,
				'minLength' => 1,
				'showAnim' => 'fold',
				'select' => "js:function(event, ui) {
					$.ajax({
						type: 'post',
						url: '$url',
						data: { user_id: '$userID', city_id: ui.item.id},
						dataType: 'json',
						success: function(response) {
							$('form #$cityID').val('');
							$('#daop-member .list-view.city .items').prepend(response.data);
						}
					});

				}"
			),
			'htmlOptions' => array(
				'class'	=> 'span-5',
				'placeholder' => 'Kota atau Kabupaten'
			),
		));	?>
		<?php echo $form->error($model,'city_input'); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
	</fieldset>
	<?php $this->endWidget(); ?>
	
	<div class="list-view city">
		<div class="items clearfix">
			<?php echo $data;?>
			<a class="pager <?php echo ($pager['itemCount'] == '0' || $pager['nextPage'] == '0') ? 'hide' : '' ?>" href="<?php echo $nextPager;?>" title="Readmore.."><span>Readmore..</span></a>
		</div>
	</div>
</div>

<?php //begin.Another DaOps ?>
<div class="boxed">
	<div class="title clearfix">
		<h2 class="specific">Specific in City</h2>
		<a class="plus" href="javascript:void(0);" title="Add Specific Operation Area">Add Specific City Operation</a>
	</div>
	<form></form>
	<div class="list-view specific">
		<div class="items clearfix">
		</div>
	</div>
</div>
