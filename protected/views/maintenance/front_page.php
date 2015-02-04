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
?>

<div class="boxed">
	<?php echo Phrase::trans($model->desc,2)?>
	<div class="date">
		<?php if($model->modified_date != '0000-00-00 00:00:00') {
			echo 'Edited: '.Utility::dateFormat($model->modified_date, true).' by '.$model->modified->displayname;
		} else {
			echo Utility::dateFormat($model->creation_date, true).' by '.$model->user->displayname;
		}?>
	<?php ;?>
	</div>
</div>