<?php
/**
 * SupportMailSetting (support-mail-setting)
 * @var $this MailsettingController
 * @var $model SupportMailSetting
 * @var $form CActiveForm
 * version: 0.2.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Support
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Support Mail Settings'=>array('manage'),
		$model->id=>array('view','id'=>$model->id),
		'Update',
	);
?>

<div class="form" name="post-on">
	<?php echo $this->renderPartial('/o/mail_setting/_form', array('model'=>$model)); ?>
</div>
