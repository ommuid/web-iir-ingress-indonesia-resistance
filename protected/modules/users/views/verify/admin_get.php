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

if(isset($_GET['name']) && isset($_GET['email'])) {?>
	<div class="users-forgot">
		<div>
			<?php echo Phrase::trans(16235,1, array(
				$_GET['name'],
				$_GET['email'],
			));?>
		</div>
	</div>

<?php } else {
	echo $this->renderPartial('_form', array(
		'model'=>$model,
	));
}?>