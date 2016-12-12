<?php
/**
 * Articles (articles)
 * @var $this AdminController
 * @var $model Articles
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Articles
 * @contact (+62)856-299-4114
 *
 */

	$controller = strtolower(Yii::app()->controller->id);
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
		$('div#quote').slideDown();
		if(id == '1') {
			$('div.filter#media').slideDown();
		} else if(id == '2') {
			$('div.filter#video').slideDown();
		} else if(id == '3') {
			$('div.filter#audio').slideDown();
		} else if(id == '4') {
			$('div#title').slideUp();
			$('div#quote').slideUp();
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
				<div class="clearfix" id="type">
					<?php echo $model->isNewRecord ? $form->labelEx($model,'article_type') : '<label>'.$model->getAttributeLabel('article_type').'</label>'; ?>
					<div class="desc">
						<?php
						if($model->isNewRecord) {
							$type_active = unserialize($setting->type_active);
							$arrAttrParams = array();
							if($setting->type_active != '' && !empty($type_active)) {
								foreach($type_active as $key => $row) {
									$part = explode('=', $row);
									$arrAttrParams[$part[0]] = Yii::t('phrase', $part[1]);
								}
							}
							echo $form->dropDownList($model,'article_type', $arrAttrParams);
							//echo $form->dropDownList($model,'article_type', $arrAttrParams, array('prompt'=>Yii::t('phrase', 'Choose one')));
						} else {
							if($model->article_type == 1)
								echo '<strong>'.Yii::t('phrase', 'Standard').'</strong>';
							elseif($model->article_type == 2)
								echo '<strong>'.Yii::t('phrase', 'Video').'</strong>';
							/* elseif($model->article_type == 3)
								echo '<strong>'.Yii::t('phrase', 'Audio').'</strong>'; */
							elseif($model->article_type == 4)
								echo '<strong>'.Yii::t('phrase', 'Quote').'</strong>';
						}?>
						<?php echo $form->error($model,'article_type'); ?>
					</div>
				</div>

				<div class="clearfix">
					<?php echo $form->labelEx($model,'cat_id'); ?>
					<div class="desc">
						<?php
						$parent = null;
						$category = ArticleCategory::getCategory(null, $parent);

						if($category != null)
							echo $form->dropDownList($model,'cat_id', $category);
						else
							echo $form->dropDownList($model,'cat_id', array('prompt'=>Yii::t('phrase', 'No Parent')));?>
						<?php echo $form->error($model,'cat_id'); ?>
					</div>
				</div>
	
				<div id="title" class="clearfix <?php echo $model->article_type == 4 ? 'hide' : '';?>">
					<label><?php echo $model->getAttributeLabel('title');?> <span class="required">*</span></label>
					<div class="desc">
						<?php echo $form->textField($model,'title',array('maxlength'=>128,'class'=>'span-8')); ?>
						<?php echo $form->error($model,'title'); ?>
					</div>
				</div>
	
				<?php if(!$model->isNewRecord && ($model->article_type == 1 && $setting->media_limit == 1)) {
					$model->old_media_input = $model->cover->media;
					echo $form->hiddenField($model,'old_media_input');
					if($model->media_id != 0) {
						$image = Yii::app()->request->baseUrl.'/public/article/'.$model->article_id.'/'.$model->old_media_input;
						$media = '<img src="'.Utility::getTimThumb($image, 320, 150, 1).'" alt="">';
						echo '<div class="clearfix">';
						echo $form->labelEx($model,'old_media_input');
						echo '<div class="desc">'.$media.'</div>';
						echo '</div>';
					}
				}?>

				<?php if($model->isNewRecord || (!$model->isNewRecord && $model->article_type == 2)) {?>
					<div id="video" class="clearfix filter <?php echo $model->isNewRecord ? 'hide' : ''?>">
						<label for="Articles_video"><?php echo $model->getAttributeLabel('video_input');?> <span class="required">*</span></label>
						<div class="desc">
							<?php $model->video_input = $model->cover->media;
							echo $form->textField($model,'video_input',array('maxlength'=>32, 'class'=>'span-8')); ?>
							<?php echo $form->error($model,'video_input'); ?>
							<span class="small-px">http://www.youtube.com/watch?v=<strong>HOAqSoDZSho</strong></span>
						</div>
					</div>
				<?php }?>

				<?php if($model->isNewRecord || (!$model->isNewRecord && ($model->article_type == 1 && $setting->media_limit == 1))) {?>
				<div id="media" class="clearfix filter">
					<?php echo $form->labelEx($model,'media_input'); ?>
					<div class="desc">
						<?php echo $form->fileField($model,'media_input'); ?>
						<?php echo $form->error($model,'media_input'); ?>
						<span class="small-px">extensions are allowed: <?php echo Utility::formatFileType(unserialize($setting->media_file_type), false);?></span>
					</div>
				</div>
				<?php }?>
		
				<?php if(!$model->isNewRecord || ($model->isNewRecord && $setting->meta_keyword != '')) {?>
				<div class="clearfix">
					<?php echo $form->labelEx($model,'keyword'); ?>
					<div class="desc">
						<?php 
						if(!$model->isNewRecord) {
							//echo $form->textField($model,'keyword',array('maxlength'=>32,'class'=>'span-6'));
							$url = Yii::app()->controller->createUrl('o/tag/add', array('type'=>'article'));
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
									<div><?php echo $val->tag_TO->body;?><a href="<?php echo Yii::app()->controller->createUrl('o/tag/delete',array('id'=>$val->id,'type'=>'article'));?>" title="<?php echo Yii::t('phrase', 'Delete');?>"><?php echo Yii::t('phrase', 'Delete');?></a></div>
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
				if(!$model->isNewRecord) {
					$model->old_media_file = $model->media_file;
					echo $form->hiddenField($model,'old_media_file');
					if($model->media_file != '') {
						$file = Yii::app()->request->baseUrl.'/public/article/'.$model->article_id.'/'.$model->media_file;
						echo '<div class="clearfix">';
						echo $form->labelEx($model,'old_media_file');
						echo '<div class="desc"><a href="'.$file.'" title="'.$model->media_file.'">'.$model->media_file.'</a></div>';
						echo '</div>';
					}
				}?>
				<div class="clearfix">
					<?php echo $form->labelEx($model,'media_file'); ?>
					<div class="desc">
						<?php echo $form->fileField($model,'media_file'); ?>
						<?php echo $form->error($model,'media_file'); ?>
						<span class="small-px">extensions are allowed: <?php echo Utility::formatFileType(unserialize($setting->upload_file_type), false);?></span>
					</div>
				</div>
	
				<div class="clearfix">
					<?php echo $form->labelEx($model,'published_date'); ?>
					<div class="desc">
						<?php 
						$model->published_date = $model->isNewRecord && $model->published_date == '' ? date('d-m-Y') : date('d-m-Y', strtotime($model->published_date));
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
	</fieldset>

	<fieldset>
		<?php if($model->isNewRecord || (!$model->isNewRecord && $model->article_type != 4)) {?>
		<div class="clearfix <?php echo $model->article_type == 4 ? 'hide' : '';?>" id="quote">
			<?php echo $form->labelEx($model,'quote'); ?>
			<div class="desc">
				<?php 
				//echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50, 'class'=>'span-10 small'));
				$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
					'model'=>$model,
					'attribute'=>quote,
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
				<?php if($model->isNewRecord || (!$model->isNewRecord && $model->article_type != 4)) {?>
					<span class="small-px"><?php echo Yii::t('phrase', 'Note : add {$quote} in description article');?></span>
				<?php }?>
				<?php echo $form->error($model,'quote'); ?>
			</div>
		</div>
		<?php }?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'body'); ?>
			<div class="desc">
				<?php 
				//echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50, 'class'=>'span-10 small'));
				$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
					'model'=>$model,
					'attribute'=>body,
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
				<?php echo $form->error($model,'body'); ?>
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
