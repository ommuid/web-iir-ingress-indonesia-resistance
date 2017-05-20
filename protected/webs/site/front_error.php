<?php
/**
 * @var $this SiteController
 * @var $error array
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Error',
	);
?>

<h1>Error <?php echo $code; ?></h1>
<h2><?php echo CHtml::encode($message); ?></h2>
