<?php
/**
 * @var $this ContactController
 * @var $model SupportMails
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */
 
	$this->breadcrumbs=array(
		'Support Mails'=>array('manage'),
		'Create',
	);
	
	$cs = Yii::app()->getClientScript();
	$cs->registerScriptFile('http://maps.googleapis.com/maps/api/js?sensor=false', CClientScript::POS_END);
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/externals/support/plugin/custom.js', CClientScript::POS_END);
$js = <<<EOP
	initialize();
EOP;
	$ukey = md5(uniqid(mt_rand(), true));
	$cs->registerScript($ukey, $js);
?>

<?php //begin.Maps ?>
<div id="maps"></div>

<?php //begin.Address, Contact and Social Media ?>
<div class="address-social">
	<?php //begin.Address ?>
	<div class="address">
		<strong><?php echo $model->office_name != '' ? $model->office_name : OmmuSettings::getInfo('site_title');?></strong><br/>
		<?php echo $model->office_place.'.<br/>'.$model->office_village.', '.$model->office_district.',<br/>'.OmmuZoneCity::getInfo($model->office_city, 'city').', '.OmmuZoneCountry::getInfo($model->office_country, 'country').',<br/>'.$model->office_zipcode?>
	</div>
	
	<?php //begin.Contact ?>
	<?php if($model->office_phone != '' || $model->office_fax != '' || $model->office_hotline != '' || $model->office_email != '') {?>
	<div class="contact">
		<strong>&nbsp;</strong><br/>
		<?php echo $model->office_phone != '' ? $model->getAttributeLabel('office_phone').': '.$model->office_phone.'<br/>' : ''?>
		<?php echo $model->office_fax != '' ? $model->getAttributeLabel('office_fax').': '.$model->office_fax.'<br/>' : ''?>
		<?php echo $model->office_hotline != '' ? $model->getAttributeLabel('office_hotline').': '.$model->office_hotline.'<br/>' : ''?>
		<?php echo $model->office_email != '' ? $model->getAttributeLabel('office_email').': <a off_address="" href="mailto:'.$model->office_email.'" title="'.$model->office_email.'">'.$model->office_email.'</a>' : ''?>		
	</div>
	<?php }?>
	
	<?php //begin.Social Media ?>
	<?php if($contact != null) {?>
	<div class="social-media">
		<ul class="clearfix">
			<?php foreach($contact as $key => $val) {
				if($val->cat->icons == '') {
					$images = Yii::app()->request->baseUrl.'/public/support/default.png';
				} else {
					$images = Yii::app()->request->baseUrl.'/public/support/'.$val->cat->icons;
				}
				if($val->cat_id == 3) {
					$url = 'ymsgr:sendim?'.$val->value;
					$target = '';
				} else {
					$url = $val->value;
					$target = 'target="_blank"';
				}
				echo '<li><a off_address="" href="'.$url.'" title="'.Phrase::trans($val->cat->name, 2).'" '.$target.'><img src="'.$images.'" alt="'.Phrase::trans($val->cat->name, 2).'"></a></li>';
			}?>
		</ul>
	</div>
	<?php }?>
</div>