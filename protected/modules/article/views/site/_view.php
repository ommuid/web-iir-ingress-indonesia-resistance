<?php
/**
 * @var $this ArticlesController
 * @var $data Articles
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('article_id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->article_id), array('view', 'id'=>$data->article_id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('publish')); ?>:</b>
    <?php echo CHtml::encode($data->publish); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('cat_id')); ?>:</b>
    <?php echo CHtml::encode($data->cat_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
    <?php echo CHtml::encode($data->user_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('media_id')); ?>:</b>
    <?php echo CHtml::encode($data->media_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('headline')); ?>:</b>
    <?php echo CHtml::encode($data->headline); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('comment_code')); ?>:</b>
    <?php echo CHtml::encode($data->comment_code); ?>
    <br />

    <?php /*
    <b><?php echo CHtml::encode($data->getAttributeLabel('article_type')); ?>:</b>
    <?php echo CHtml::encode($data->article_type); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
    <?php echo CHtml::encode($data->title); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('body')); ?>:</b>
    <?php echo CHtml::encode($data->body); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('quote')); ?>:</b>
    <?php echo CHtml::encode($data->quote); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('published_date')); ?>:</b>
    <?php echo CHtml::encode($data->published_date); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
    <?php echo CHtml::encode($data->comment); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('view')); ?>:</b>
    <?php echo CHtml::encode($data->view); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('likes')); ?>:</b>
    <?php echo CHtml::encode($data->likes); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>:</b>
    <?php echo CHtml::encode($data->creation_date); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('modified_date')); ?>:</b>
    <?php echo CHtml::encode($data->modified_date); ?>
    <br />

    */ ?>

</div>