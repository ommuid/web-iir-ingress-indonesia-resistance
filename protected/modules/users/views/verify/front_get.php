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

if(isset($_GET['name']) && isset($_GET['email'])) {
	echo Phrase::trans(16187,1).', '.$_GET['name'].' sebuah code verifikasi telah kami kirimkan ke email '.$_GET['email'];

} else {?>
	<div class="form">
		<?php echo $this->renderPartial('_form', array(
			'model'=>$model,
		)); ?>
	</div>
<?php }?>