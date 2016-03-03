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

<div class="boxed city">
	<?php //begin.My City and Suggest Agent ?>
	<div class="table">
		<?php //begin.My City ?>
		<div class="box">
			<div class="title">
				<h2 id="city-title"><span></span> City</h2>
			</div>
			<div class="list-view" id="city-data">
				<div class="items city clearfix">
					<div class="loader"></div>
				</div>
			</div>
		</div>
		
		<?php //begin.Suggest Agent ?>
		<div class="box medium">
			<div class="title">
				<h2 id="agent-title"><span></span> Agent Suggest</h2>
			</div>
			<div class="list-view">
				<div class="items clearfix">
					<div class="loader"></div>
				</div>
			</div>
		</div>
	</div>
	<?php //end.My City and Suggest Agent ?>
	
	<?php //begin.City Suggest ?>
	<div class="suggest">
		<?php //begin.Title ?>
		<div class="title clearfix">
			<h2 id="city-suggest-title"><span></span> City Suggest</h2>
			<div class="left">
				<a href="javascript:void(0);" title="City Suggest Filter">Filter</a>
			</div>
		</div>
		<?php //begin.Filter City ?>
		<div class="filter">
			<span class="arrow"></span>
			<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
				'id' => 'daop-users-form',
				'method' => 'get',
				'action' => Yii::app()->controller->createUrl('citysuggest'),
				'enableAjaxValidation' => true,
				'htmlOptions' => array(
					'keyup' => '',
				),
			)); ?>
				<fieldset class="clearfix">
					<div>
						<?php echo $form->dropDownList($model,'province_id', OmmuZoneProvince::getProvince(72), array('prompt'=>'All Province'));?>
					</div>
					<div>
						<?php echo $form->textField($model,'city_input',array('class'=>'span-5','placeholder'=>'Kota atau Kabupaten'));?>
					</div>
					<?php echo CHtml::submitButton('Filter', array('onclick' => 'setEnableSave()')); ?>
				</fieldset>
			<?php $this->endWidget(); ?>
		</div>
		<?php //begin.Render Data ?>
		<div class="list-view" id="city-suggest-data">
			<div class="items city clearfix">
				<div class="loader"></div>
			</div>
		</div>
	</div>
	<?php //end.City Suggest ?>
</div>

<?php //begin.Specific City ?>
<div class="boxed specific">
	<div class="box">
		<div class="title clearfix">
			<h2 id="specific-title"><span></span> Specific in City</h2>
			<div class="left">
				<a href="javascript:void(0);" title="Specific in City Suggest">Specific Suggest</a>
			</div>
		</div>
	
		<?php //begin.Specific Suggest ?>
		<div class="suggest">
			<div class="filter">
				<span class="arrow"></span>
				<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
					'id' => 'daop-users-form',
					'method' => 'get',
					'action' => Yii::app()->controller->createUrl('anothersuggest'),
					'enableAjaxValidation' => true,
					'htmlOptions' => array(
						'keyup' => '',
					),
				)); ?>
					<fieldset>
						<?php echo $form->dropDownList($another,'provinceId_search', OmmuZoneProvince::getProvince(72), array('prompt'=>'All Province'));?>
						<?php echo $form->dropDownList($another,'cityId_search', OmmuZoneCity::getCity(), array('prompt'=>'All City'));?>
						<?php echo $form->textField($another,'another_input',array('class'=>'span-5','placeholder'=>'Kelurahan, Kecamatan atau Nama Jalan'));?>
						<?php echo CHtml::submitButton('Filter', array('onclick' => 'setEnableSave()')); ?>
					</fieldset>
					<fieldset>
						<?php echo $form->textField($another,'another_input',array('class'=>'span-5','placeholder'=>'Kelurahan, Kecamatan atau Nama Jalan'));?>
						<?php echo CHtml::submitButton('Filter', array('onclick' => 'setEnableSave()')); ?>
					</fieldset>
				<?php $this->endWidget(); ?>
			</div>
			<?php //begin.Render Data ?>
			<div class="list-view" id="specific-suggest-data">
				<div class="items specific clearfix">
					<div class="loader"></div>
				</div>
			</div>
		</div>
		<?php //end.Specific Suggest ?>
		
		<div class="list-view" id="specific-data">
			<div class="items specific clearfix">
				<div class="loader"></div>
			</div>
		</div>
	</div>
</div>
<?php //end.Specific City ?>