<?php
/**
 * @var $this PageController
 * @var $model OmmuPages
 * @var $form CActiveForm */
	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$('input#OmmuPages_media_show').change(function(){
		var type = $(this).parents('form').attr('action');
		var checked = $(this).attr('checked');
		if(checked == 'checked') {
			$('form[action="'+type+'"]').find('div#media').slideDown();
		} else {
			$('form[action="'+type+'"]').find('div#media').slideUp();
		}
	});
EOP;
	$cs->registerScript('mediashow', $js, CClientScript::POS_END);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'ommu-pages-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<div id="ajax-message">
		<?php echo $form->errorSummary($model); ?>
	</div>

	<fieldset class="clearfix">
		<div class="clear">
			<div class="left">

				<div class="clearfix">
					<?php echo $form->labelEx($model,'title'); ?>
					<div class="desc">
						<?php
						$model->title = Phrase::trans($model->name, 2);
						echo $form->textField($model,'title',array('maxlength'=>256,'class'=>'span-6')); ?>
						<?php echo $form->error($model,'title'); ?>
					</div>
				</div>

				<div class="clearfix">
					<?php echo $form->labelEx($model,'description'); ?>
					<div class="desc">
						<?php
						$model->description = Phrase::trans($model->desc, 2);
						//echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50));
						$this->widget('application.extensions.cleditor.ECLEditor', array(
							'model'=>$model,
							'attribute'=>'description',
							'options'=>array(
								'width'=>'90%',
								'height'=>250,
								'useCSS'=>true,
								'controls'=>'bold italic underline strikethrough subscript superscript | bullets numbering | outdent indent | alignleft center alignright justify | undo redo | rule image link unlink | cut copy paste pastetext | print source',
							),
						)); ?>
						<?php echo $form->error($model,'description'); ?>
					</div>
				</div>

				<?php /*<div class="clearfix">
					<?php echo $form->labelEx($model,'description'); ?>
					<div class="desc">
						<?php
						$model->description = Phrase::trans($model->desc, 2);
						//echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50));
						$options = array(
							'lang' => 'en',
							'buttons' => array('html', '|', 'bold', 'italic', '|',
								'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
								'image', 'video', 'file', 'table', 'link', '|', 'horizontalrule'
							),
						);
						$this->widget('application.extensions.imperavi-redactor.ImperaviRedactorWidget', array(
							'model'=>$model,
							'attribute'=>'description',
							'options'   => $options
						)); ?>
						<?php echo $form->error($model,'description'); ?>
					</div>
				</div> */?>

			</div>
			<div class="right">

				<?php if($model->isNewRecord) {?>
					<div class="clearfix">
						<?php echo $form->labelEx($model,'media'); ?>
						<div class="desc">
							<?php echo $form->fileField($model,'media',array('maxlength'=>64)); ?>
							<?php echo $form->error($model,'media'); ?>
						</div>
					</div>
				<?php } else {?>
					<div class="clearfix publish">
						<?php echo $form->labelEx($model,'media_show'); ?>
						<div class="desc">
							<?php echo $form->checkBox($model,'media_show'); ?><label><?php echo $model->getAttributeLabel('media_show');?></label>
							<?php echo $form->error($model,'media_show'); ?>
						</div>
					</div>
					<div id="media" <?php echo $model->media_show == 0 ? 'class="hide"' : '';?>>
						<?php if($model->media != '') {
							$model->old_media = $model->media;
							echo $form->hiddenField($model,'old_media');
							$images = Yii::app()->request->baseUrl.'/public/page/'.$model->media;
						?>
							<div class="clearfix">
								<?php echo $form->labelEx($model,'old_media'); ?>
								<div class="desc">
									<img src="<?php echo Utility::getTimThumb($images, 320, 150, 1);?>" alt="">
								</div>
							</div>
						<?php }?>

						<div class="clearfix">
							<?php echo $form->labelEx($model,'media'); ?>
							<div class="desc">
								<?php echo $form->fileField($model,'media',array('maxlength'=>64)); ?>
								<?php echo $form->error($model,'media'); ?>
							</div>
						</div>

						<div class="clearfix <?php echo $model->media == '' ? 'hide' : '';?>">
							<?php echo $form->labelEx($model,'media_type'); ?>
							<div class="desc">
								<?php echo $form->dropDownList($model,'media_type', array(
									1 => Phrase::trans(344,0),
									2 => Phrase::trans(345,0),
								), array('prompt'=>Phrase::trans(346,0))); ?>
								<?php echo $form->error($model,'media_type'); ?>
							</div>
						</div>
					</div>
				<?php }?>

				<div class="clearfix publish">
					<?php echo $form->labelEx($model,'publish'); ?>
					<div class="desc">
						<?php echo $form->checkBox($model,'publish'); ?><label><?php echo $model->getAttributeLabel('publish');?></label>
						<?php echo $form->error($model,'publish'); ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="submit clearfix">
			<label>&nbsp;</label>
			<div class="desc">
				<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>

	</fieldset>
<?php $this->endWidget(); ?>

