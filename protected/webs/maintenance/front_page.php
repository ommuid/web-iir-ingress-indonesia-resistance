<?php
/**
 * User Verify (user-verify)
 * @var $this VerifyController
 * @var $model UserVerify
 * version: 1.1.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
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