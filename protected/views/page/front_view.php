<?php
/**
 * @var $this OmmuPagesController
 * @var $model OmmuPages
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */
 
	$this->breadcrumbs=array(
		'Ommu Pages'=>array('manage'),
		$model->name,
	);
?>

<?php $this->widget('application.components.system.FDetailView', array( 
    'data'=>$model, 
    'attributes'=>array( 
        'page_id',
        'publish',
        'user_id',
        'name',
        'desc',
        'media',
        'media_show',
        'media_type',
        'creation_date',
        'modified_date',
    ), 
)); ?> 