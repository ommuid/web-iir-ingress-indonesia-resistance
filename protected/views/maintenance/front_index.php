<?php
/**
 * @var $this VerifyController
 * @var $model UserVerify
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */
 
	$this->breadcrumbs=array(
		'User Verifies'=>array('manage'),
		'Create',
	);
	
	$date = date('Y/m/d', strtotime($setting->construction_date));

	$cs = Yii::app()->getClientScript();
	$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/plugin/jquery.countdown.js', CClientScript::POS_END);
	//$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/plugin/dt-timecircles.js', CClientScript::POS_END);
$js=<<<EOP
	var startDate = '$date';
EOP;
	$cs->registerScript('countdown', $js, CClientScript::POS_END);	
?>

<div class="countdown">
	<ul class="clearfix">
		<li>
			<span id="days">0</span>
			<?php echo Phrase::trans(334,0);?>
		</li>
		<li>
			<span id="hours">0</span>
			<?php echo Phrase::trans(335,0);?>
		</li>
		<li>
			<span id="minutes">0</span>
			<?php echo Phrase::trans(336,0);?>
		</li>
		<li>
			<span id="seconds">0</span>
			<?php echo Phrase::trans(337,0);?>
		</li>
	</ul>
</div>

<p><?php echo $setting->construction_text;?></p>

<?php /*
<div class="dt-countdowntimer" data-date="<?php echo $setting->construction_date;?>" style="height: 250px;"></div>
*/?>
