<?php
/**
 * Ommu Pages (ommu-pages)
 * @var $this PageController
 * @var $model OmmuPages
 * @var $form CActiveForm
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */
 
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
					<?php echo $form->labelEx($model,'title_i'); ?>
					<div class="desc">
						<?php
							if(!$model->getErrors())
						$model->title_i = Phrase::trans($model->name);
						echo $form->textField($model,'title_i',array('maxlength'=>256,'class'=>'span-6')); ?>
						<?php echo $form->error($model,'title_i'); ?>
					</div>
				</div>
				
				<div class="clearfix">
					<?php echo $form->labelEx($model,'quote_i'); ?>
					<div class="desc">
						<?php 
						if(!$model->getErrors())
							$model->quote_i = Phrase::trans($model->quote);
						//echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50, 'class'=>'span-10 small'));
						$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
							'model'=>$model,
							'attribute'=>quote_i,
							// Redactor options
							'options'=>array(
								//'lang'=>'fi',
								'buttons'=>array(
									'html', '|', 
									'bold', 'italic', 'deleted', '|',
								),
							),
							'plugins' => array(
								'fontcolor' => array('js' => array('fontcolor.js')),
								'fullscreen' => array('js' => array('fullscreen.js')),
							),
						)); ?>
						<span class="small-px">Note : add {$quote} in description static pages</span>
						<?php echo $form->error($model,'quote_i'); ?>
					</div>
				</div>

				<div class="clearfix">
					<?php echo $form->labelEx($model,'description_i'); ?>
					<div class="desc">
						<?php
						if(!$model->getErrors())
							$model->description_i = Phrase::trans($model->desc);
						//echo $form->textArea($model,'description_i',array('rows'=>6, 'cols'=>50));
						$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
							'model'=>$model,
							'attribute'=>description_i,
							// Redactor options
							'options'=>array(
								//'lang'=>'fi',
								'buttons'=>array(
									'html', 'formatting', '|', 
									'bold', 'italic', 'deleted', '|',
									'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
									'link', '|',
								),
							),
							'plugins' => array(
								'fontcolor' => array('js' => array('fontcolor.js')),
								'table' => array('js' => array('table.js')),
								'fullscreen' => array('js' => array('fullscreen.js')),
							),
						)); ?>
						<?php echo $form->error($model,'description_i'); ?>
					</div>
				</div>

				<?php /*<div class="clearfix">
					<?php echo $form->labelEx($model,'description_i'); ?>
					<div class="desc">
						<?php
						$model->description_i = Phrase::trans($model->desc);
						//echo $form->textArea($model,'description_i',array('rows'=>6, 'cols'=>50));
						$options = array(
							'lang' => 'en',
							'buttons' => array('html', '|', 'bold', 'italic', '|',
								'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
								'image', 'video', 'file', 'table', 'link', '|', 'horizontalrule'
							),
						);
						$this->widget('application.extensions.imperavi-redactor.ImperaviRedactorWidget', array(
							'model'=>$model,
							'attribute'=>'description_i',
							'options'   => $options
						)); ?>
						<?php echo $form->error($model,'description_i'); ?>
					</div>
				</div> */?>

			</div>
			<div class="right">

				<?php if($model->isNewRecord) {?>
					<div class="clearfix">
						<?php echo $form->labelEx($model,'media'); ?>
						<div class="desc">
							<?php echo $form->fileField($model,'media'); ?>
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
							$model->old_media_i = $model->media;
							echo $form->hiddenField($model,'old_media_i');
							$images = Yii::app()->request->baseUrl.'/public/page/'.$model->old_media_i;
						?>
							<div class="clearfix">
								<?php echo $form->labelEx($model,'old_media_i'); ?>
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
									1 => Yii::t('phrase', 'Large'),
									2 => Yii::t('phrase', 'Medium'),
								), array('prompt'=>Yii::t('phrase', 'Select type'))); ?>
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
				<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>

	</fieldset>
<?php $this->endWidget(); ?>

