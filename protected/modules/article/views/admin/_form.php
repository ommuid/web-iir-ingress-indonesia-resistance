<?php
/**
 * @var $this AdminController
 * @var $model Articles
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	if($model->isNewRecord || (!$model->isNewRecord && ($model->article_type == 3 || ($model->article_type == 1 && $setting->media_limit == 1)))) {
		$validation = false;
	} else {
		$validation = true;
	}

	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$('select#Articles_article_type').live('change', function() {
		var id = $(this).val();
		$('fieldset div.filter').slideUp();
		$('div#title').slideDown();
		if(id == '1') {
			$('div.filter#media').slideDown();
		} else if(id == '2') {
			$('div.filter#video').slideDown();
		} else if(id == '3') {
			$('div.filter#audio').slideDown();
		} else if(id == '4') {
			$('div#title').slideUp();
		}
	});
EOP;
	$cs->registerScript('type', $js, CClientScript::POS_END);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'articles-form',
	'enableAjaxValidation'=>$validation,
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php 
		echo $form->errorSummary($model);
		if(Yii::app()->user->hasFlash('error'))
			echo Utility::flashError(Yii::app()->user->getFlash('error'));
		if(Yii::app()->user->hasFlash('success'))
			echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
		?>
	</div>
	<?php //begin.Messages ?>

	<fieldset class="clearfix">
		<div class="clear">
			<div class="left">
	
				<div class="clearfix">
					<?php echo $model->isNewRecord ? $form->labelEx($model,'article_type') : '<label>'.$model->getAttributeLabel('article_type').'</label>'; ?>
					<div class="desc">
						<?php
						if($model->isNewRecord) {
							$arrAttrParams = array();
							if($setting->type_active != '') {
								$arrAttr = explode(',', $setting->type_active);
								if(count($arrAttr) > 0) {
									foreach($arrAttr as $row) {
										$part = explode('=', $row);
										$arrAttrParams[$part[0]] = Phrase::trans($part[1],1);
									}
								}
							}
							echo $form->dropDownList($model,'article_type', $arrAttrParams, array('prompt'=>Phrase::trans(26042,1)));
						} else {
							if($model->article_type == 1)
								echo '<strong>'.Phrase::trans(26043,1).'</strong>';
							elseif($model->article_type == 2)
								echo '<strong>'.Phrase::trans(26044,1).'</strong>';
							elseif($model->article_type == 3)
								echo '<strong>'.Phrase::trans(26045,1).'</strong>';
							elseif($model->article_type == 4)
								echo '<strong>'.Phrase::trans(26046,1).'</strong>';
						}?>
						<?php echo $form->error($model,'article_type'); ?>
					</div>
				</div>

				<div class="clearfix">
					<?php echo $form->labelEx($model,'cat_id'); ?>
					<div class="desc">
						<?php if(ArticleCategory::getCategory(1) != null) {
							echo $form->dropDownList($model,'cat_id', ArticleCategory::getCategory(1));
						} else {
							echo $form->dropDownList($model,'cat_id', array('prompt'=>Phrase::trans(26019,1)));
						}?>
						<?php echo $form->error($model,'cat_id'); ?>
					</div>
				</div>
	
				<div id="title" class="clearfix <?php echo $model->article_type == 4 ? 'hide' : '';?>">
					<label><?php echo $model->getAttributeLabel('title');?> <span class="required">*</span></label>
					<div class="desc">
						<?php echo $form->textField($model,'title',array('maxlength'=>64,'class'=>'span-8')); ?>
						<?php echo $form->error($model,'title'); ?>
					</div>
				</div>
	
				<?php //if($model->isNewRecord || (!$model->isNewRecord && $model->article_type != 4)) {?>
				<div class="clearfix" id="quote">
					<?php echo $form->labelEx($model,'quote'); ?>
					<div class="desc">
						<?php echo $form->textArea($model,'quote',array('rows'=>6, 'cols'=>50, 'class'=>'span-10 small')); ?>
						<?php if($model->isNewRecord || (!$model->isNewRecord && $model->article_type != 4)) {?>
							<span class="small-px"><?php echo Phrase::trans(26084,1);?></span>
						<?php }?>
						<?php echo $form->error($model,'quote'); ?>
					</div>
				</div>
				<?php //}?>
	
				<div class="clearfix">
					<?php echo $form->labelEx($model,'body'); ?>
					<div class="desc">
						<?php 
						//echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50));
						$this->widget('application.extensions.cleditor.ECLEditor', array(
							'model'=>$model,
							'attribute'=>'body',
							'options'=>array(
								'width'=>'100%',
								'height'=>250,
								'useCSS'=>true,
								'controls'=>'bold italic underline strikethrough subscript superscript | bullets numbering | outdent indent | alignleft center alignright justify | undo redo | rule image link unlink | cut copy paste pastetext | print source',
							),
							'value'=>$model->body,
						)); ?>
						<?php echo $form->error($model,'body'); ?>
					</div>
				</div>
				
				<?php if(!$model->isNewRecord || ($model->isNewRecord && $setting->meta_keyword != '')) {?>
				<div class="clearfix">
					<?php echo $form->labelEx($model,'keyword'); ?>
					<div class="desc">
						<?php 
						if(!$model->isNewRecord) {
							//echo $form->textField($model,'keyword',array('maxlength'=>32,'class'=>'span-6'));
							$url = Yii::app()->controller->createUrl('tag/add', array('type'=>'article'));
							$article = $model->article_id;
							$tagId = 'Articles_keyword';
							$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
								'model' => $model,
								'attribute' => 'keyword',
								'source' => Yii::app()->createUrl('globaltag/suggest'),
								'options' => array(
									//'delay '=> 50,
									'minLength' => 1,
									'showAnim' => 'fold',
									'select' => "js:function(event, ui) {
										$.ajax({
											type: 'post',
											url: '$url',
											data: { article_id: '$article', tag_id: ui.item.id, tag: ui.item.value },
											dataType: 'json',
											success: function(response) {
												$('form #$tagId').val('');
												$('form #keyword-suggest').append(response.data);
											}
										});
		
									}"
								),
								'htmlOptions' => array(
									'class'	=> 'span-6',
								),
							));
							echo $form->error($model,'keyword');
						}?>
						<div id="keyword-suggest" class="suggest clearfix">
							<?php 
							$arrKeyword = explode(',', $setting->meta_keyword);
							foreach($arrKeyword as $row) {?>
								<div class="d"><?php echo $row;?></div>
							<?php }
							if(!$model->isNewRecord) {
								if($tag != null) {
									foreach($tag as $key => $val) {?>
									<div><?php echo $val->tag->body;?><a href="<?php echo Yii::app()->controller->createUrl('tag/delete',array('id'=>$val->id,'type'=>'article'));?>" title="<?php echo Phrase::trans(173,0);?>"><?php echo Phrase::trans(173,0);?></a></div>
								<?php }
								}
							}?>						
						</div>
					</div>
				</div>
				<?php }?>
	
			</div>
	
			<div class="right">
	
				<?php
				if(!$model->isNewRecord && ($model->article_type == 3 || ($model->article_type == 1 && $setting->media_limit == 1))) {
					$model->old_media = $model->cover->media;
					echo $form->hiddenField($model,'old_media');
					if($model->media_id != 0) {
						$file = Yii::app()->request->baseUrl.'/public/article/'.$model->article_id.'/'.$model->cover->media;
						if($model->article_type == 1) {
							$media = '<img src="'.Utility::getTimThumb($file, 320, 150, 1).'" alt="">';
						} elseif($model->article_type == 3) {
							$media = '<audio src="'.$file.'" controls="true" loop="true" autoplay="false"></audio>';
						}
						echo '<div class="clearfix">';
						echo $form->labelEx($model,'old_media');
						echo '<div class="desc">'.$media.'</div>';
						echo '</div>';
					}
				}?>
	
				<?php if($model->isNewRecord || (!$model->isNewRecord && $model->article_type == 1 && $setting->media_limit == 1)) {?>
				<div id="media" class="clearfix filter <?php echo $model->isNewRecord ? 'hide' : ''?>">
					<?php echo $form->labelEx($model,'media'); ?>
					<div class="desc">
						<?php echo $form->fileField($model,'media',array('maxlength'=>64)); ?>
						<?php echo $form->error($model,'media'); ?>
					</div>
				</div>
				<?php }?>
	
				<?php if($model->isNewRecord || (!$model->isNewRecord && $model->article_type == 2)) {?>
				<div id="video" class="clearfix filter <?php echo $model->isNewRecord ? 'hide' : ''?>">
					<label for="Articles_video"><?php echo $model->getAttributeLabel('video');?> <span class="required">*</span></label>
					<div class="desc">
						<?php $model->video = $model->cover->media;
						echo $form->textField($model,'video',array('maxlength'=>32, 'class'=>'span-8')); ?>
						<?php echo $form->error($model,'video'); ?>
						<span class="small-px">http://www.youtube.com/watch?v=<strong>HOAqSoDZSho</strong></span>
					</div>
				</div>
				<?php }?>
	
				<?php if($model->isNewRecord || (!$model->isNewRecord && $model->article_type == 3)) {?>
				<div id="audio" class="clearfix filter <?php echo $model->isNewRecord ? 'hide' : ''?>">
					<label for="Articles_audio"><?php echo $model->getAttributeLabel('audio');?></label>
					<div class="desc">
						<?php echo $form->fileField($model,'audio',array('maxlength'=>64)); ?>
						<?php echo $form->error($model,'audio'); ?>
					</div>
				</div>
				<?php }?>
	
				<div class="clearfix">
					<?php echo $form->labelEx($model,'published_date'); ?>
					<div class="desc">
						<?php 
						$model->isNewRecord ? '' : $model->published_date = date('d-m-Y', strtotime($model->published_date));
						//echo $form->textField($model,'published_date', array('class'=>'span-7'));
						$this->widget('zii.widgets.jui.CJuiDatePicker',array(
							'model'=>$model, 
							'attribute'=>'published_date',
							//'mode'=>'datetime',
							'options'=>array(
								'dateFormat' => 'dd-mm-yy',
							),
							'htmlOptions'=>array(
								'class' => 'span-7',
							 ),
						));	?>
						<?php echo $form->error($model,'published_date'); ?>
					</div>
				</div>
	
				<?php if(OmmuSettings::getInfo('site_type') == 1) {?>
				<div class="clearfix publish">
					<?php echo $form->labelEx($model,'comment_code'); ?>
					<div class="desc">
						<?php echo $form->checkBox($model,'comment_code'); ?><?php echo $form->labelEx($model,'comment_code'); ?>
						<?php echo $form->error($model,'comment_code'); ?>
					</div>
				</div>
				<?php } else {
					$model->comment_code = 0;
					echo $form->hiddenField($model,'comment_code');
				}?>
	
				<?php if(OmmuSettings::getInfo('site_headline') == 1) {?>
				<div class="clearfix publish">
					<?php echo $form->labelEx($model,'headline'); ?>
					<div class="desc">
						<?php echo $form->checkBox($model,'headline'); ?><?php echo $form->labelEx($model,'headline'); ?>
						<?php echo $form->error($model,'headline'); ?>
					</div>
				</div>
				<?php } else {
					$model->headline = 0;
					echo $form->hiddenField($model,'headline');
				}?>
	
				<div class="clearfix publish">
					<?php echo $form->labelEx($model,'publish'); ?>
					<div class="desc">
						<?php echo $form->checkBox($model,'publish'); ?><?php echo $form->labelEx($model,'publish'); ?>
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
