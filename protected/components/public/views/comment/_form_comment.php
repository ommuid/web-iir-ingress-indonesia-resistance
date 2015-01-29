<?php
/**
 * @var $this CommentController
 * @var $model ArticleComment
 * @var $form CActiveForm */
	if($reply == true) {
		$action = Yii::app()->createUrl('comment/add',array('comment'=>$comment));
	} else {
		$action = Yii::app()->createUrl('comment/add');
	}
	if(!Yii::app()->user->isGuest) {
		$user = Users::model()->findByPk(Yii::app()->user->id);
	}
?>

<?php $form=$this->beginWidget('OActiveForm', array(
	'action' => $action,
	'id'=>'article-comment-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php echo $form->errorSummary($model); ?>
	</div>
	<?php //begin.Messages ?>

	<fieldset>

		<?php 
			if($reply == true) {
				$model->parent = $comment;
				echo $form->hiddenField($model,'parent');
				$model->dependency = 1;
				echo $form->hiddenField($model,'dependency');
			} else {
				$model->dependency = 0;
				echo $form->hiddenField($model,'dependency');
			}
			$model->plugin_id = Yii::app()->params['plugin'];
			echo $form->hiddenField($model,'plugin_id');
			$model->content_id = $_GET['id'];
			echo $form->hiddenField($model,'content_id');
			$model->publish = 1;
			echo $form->hiddenField($model,'publish');
			
			$model->name = $user->displayname;
			echo $form->hiddenField($model,'name');
			$model->email = $user->email;
			echo $form->hiddenField($model,'email');
		?>

		<div class="clearfix">
			<?php echo $form->textArea($model,'comment',array('placeholder'=>Phrase::trans(361,0))); ?>
			<?php echo $form->error($model,'comment'); ?>
		</div>
		<div class="clearfix">
			<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(372,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
		</div>

		<?php
		/*
		<div class="info article clearfix">
			<div>
				<?php 
				$model->name = $user->displayname;
				echo $form->textField($model,'name',array('maxlength'=>32, 'placeholder'=>Phrase::trans(362,0))); ?>
				<?php echo $form->error($model,'name'); ?>
			</div>
			<div>
				<?php 
				$model->email = $user->email;
				echo $form->textField($model,'email',array('maxlength'=>32, 'placeholder'=>Phrase::trans(363,0))); ?>
				<?php echo $form->error($model,'email'); ?>
			</div>
			<div>
				<?php 
				echo $form->textField($model,'website',array('maxlength'=>64, 'placeholder'=>Phrase::trans(364,0))); ?>
				<?php echo $form->error($model,'website'); ?>
			</div>
			<div>
				<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(372,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>
		*/?>

	</fieldset>
<?php $this->endWidget(); ?>
