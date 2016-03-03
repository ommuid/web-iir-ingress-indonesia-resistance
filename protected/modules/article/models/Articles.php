<?php
/**
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 *
 * --------------------------------------------------------------------------------------
 *
 * This is the model class for table "ommu_articles".
 *
 * The followings are the available columns in table 'ommu_articles':
 * @property string $article_id
 * @property integer $publish
 * @property integer $cat_id
 * @property string $user_id
 * @property string $media_id
 * @property integer $headline
 * @property integer $comment_code
 * @property integer $article_type
 * @property string $title
 * @property string $body
 * @property string $quote 
 * @property string $published_date
 * @property integer $comment
 * @property integer $view
 * @property integer $likes
 * @property string $creation_date
 * @property string $modified_date
 *
 * The followings are the available model relations:
 * @property OmmuArticleComment[] $ommuArticleComments
 * @property OmmuArticleMedia[] $ommuArticleMedias
 * @property OmmuArticleCategory $cat
 */
class Articles extends CActiveRecord
{
	public $defaultColumns = array();
	public $media;
	public $old_media;
	public $video;
	public $audio;
	public $keyword;
	
	// Variable Search
	public $user_search;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Articles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ommu_articles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cat_id, article_type, published_date', 'required'),
			array('publish, cat_id, user_id, media_id, headline, comment_code, comment, view, likes', 'numerical', 'integerOnly'=>true),
			array('user_id, media_id', 'length', 'max'=>11),
			array('
				video, keyword', 'length', 'max'=>32),
			array('title, 
				media, old_media, audio', 'length', 'max'=>64),
			array('media', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			array('audio', 'file', 'types' => 'mp3, mp4', 'maxSize'=>7097152, 'allowEmpty' => true),
			array('media_id, title, body, quote, published_date, creation_date, modified_date, 
				media, old_media, video, audio, keyword', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('article_id, publish, cat_id, user_id, media_id, headline, comment_code, article_type, title, body, quote, published_date, comment, view, likes, creation_date, modified_date,
				user_search', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'cat' => array(self::BELONGS_TO, 'ArticleCategory', 'cat_id'),
			'cover' => array(self::BELONGS_TO, 'ArticleMedia', 'media_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'article_id' => Phrase::trans(26000,1),
			'publish' => Phrase::trans(26021,1),
			'cat_id' => Phrase::trans(26020,1),
			'user_id' => Phrase::trans(26041,1),
			'media_id' => Phrase::trans(26039,1),
			'headline' => Phrase::trans(26066,1),
			'comment_code' => Phrase::trans(26038,1),
			'article_type' => Phrase::trans(26067,1),
			'title' => Phrase::trans(26016,1),
			'body' => Phrase::trans(26036,1),
			'quote' => Phrase::trans(26085,1),
			'published_date' => Phrase::trans(26037,1),
			'comment' => Phrase::trans(26038,1),
			'view' => Phrase::trans(26040,1),
			'likes' => Phrase::trans(26068,1),
			'creation_date' => Phrase::trans(26069,1),
			'modified_date' => Phrase::trans(26070,1),
			'media' => Phrase::trans(26039,1),
			'old_media' => Phrase::trans(26071,1),
			'video' => Phrase::trans(26044,1),
			'audio' => Phrase::trans(26045,1),
			'keyword' => Phrase::trans(26079,1),
			'user_search' => Phrase::trans(26041,1),
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$controller = strtolower(Yii::app()->controller->id);
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.article_id',$this->article_id);
		if(isset($_GET['type']) && $_GET['type'] == 'publish') {
			$criteria->compare('t.publish',1);
		} elseif(isset($_GET['type']) && $_GET['type'] == 'unpublish') {
			$criteria->compare('t.publish',0);
		} elseif(isset($_GET['type']) && $_GET['type'] == 'trash') {
			$criteria->compare('t.publish',2);
		} else {
			$criteria->addInCondition('t.publish',array(0,1));
			$criteria->compare('t.publish',$this->publish);
		}
		if(isset($_GET['category'])) {
			$criteria->compare('t.cat_id',$_GET['category']);
		} else {
			$criteria->compare('t.cat_id',$this->cat_id);
		}
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.media_id',$this->media_id);
		$criteria->compare('t.headline',$this->headline);
		$criteria->compare('t.comment_code',$this->comment_code);
		$criteria->compare('t.article_type',$this->article_type);
		$criteria->compare('t.title',strtolower($this->title),true);
		$criteria->compare('t.body',strtolower($this->body),true);
		$criteria->compare('t.quote',strtolower($this->quote),true);
		if($this->published_date != null && !in_array($this->published_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.published_date)',date('Y-m-d', strtotime($this->published_date)));
		$criteria->compare('t.comment',$this->comment);
		$criteria->compare('t.view',$this->view);
		$criteria->compare('t.likes',$this->likes);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		
		// Custom Search
		$criteria->with = array(
			'user' => array(
				'alias'=>'user',
				'select'=>'displayname'
			),
		);
		$criteria->compare('user.displayname',strtolower($this->user_search), true);

		if(!isset($_GET['Articles_sort']))
			$criteria->order = 'article_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>30,
			),
		));
	}

	/**
	 * Get column for CGrid View
	 */
	public function getGridColumn($columns=null) {
		if($columns !== null) {
			foreach($columns as $val) {
				/*
				if(trim($val) == 'enabled') {
					$this->defaultColumns[] = array(
						'name'  => 'enabled',
						'value' => '$data->enabled == 1? "Ya": "Tidak"',
					);
				}
				*/
				$this->defaultColumns[] = $val;
			}
		}else {
			//$this->defaultColumns[] = 'article_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'cat_id';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'media_id';
			$this->defaultColumns[] = 'headline';
			$this->defaultColumns[] = 'comment_code';
			$this->defaultColumns[] = 'article_type';
			$this->defaultColumns[] = 'title';
			$this->defaultColumns[] = 'body';
			$this->defaultColumns[] = 'quote';
			$this->defaultColumns[] = 'published_date';
			$this->defaultColumns[] = 'comment';
			$this->defaultColumns[] = 'view';
			$this->defaultColumns[] = 'likes';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'modified_date';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		$controller = strtolower(Yii::app()->controller->id);
		if(count($this->defaultColumns) == 0) {
			/*
			$this->defaultColumns[] = array(
				'class' => 'CCheckBoxColumn',
				'name' => 'id',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'trash_id[]')
			);
			*/
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			$this->defaultColumns[] = array(
				'name' => 'title',
				'value' => '$data->title."<br/><span>".Utility::shortText(Utility::hardDecode($data->body),200)."</span>"',
				'htmlOptions' => array(
					'class' => 'bold',
				),
				'type' => 'raw',
			);
			if(!isset($_GET['category']) && $controller == 'admin') {
				$this->defaultColumns[] = array(
					'name' => 'cat_id',
					'value' => 'Phrase::trans($data->cat->name, 2)',
					'filter'=> ArticleCategory::getCategory(),
					'type' => 'raw',
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'user_search',
				'value' => '$data->user->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Utility::dateFormat($data->creation_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this, 
					'attribute'=>'creation_date', 
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'creation_date_filter',
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
			);
			if(in_array($controller, array('admin'))) {
				$this->defaultColumns[] = array(
					'name' => 'published_date',
					'value' => 'Utility::dateFormat($data->published_date)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$this, 
						'attribute'=>'published_date', 
						'language' => 'ja',
						'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
						//'mode'=>'datetime',
						'htmlOptions' => array(
							'id' => 'published_date_filter',
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
					), true),
				);
			}
			if(OmmuSettings::getInfo('site_headline') == 1) {
				$this->defaultColumns[] = array(
					'name' => 'headline',
					'value' => '$data->headline == 1 ? Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Utility::getPublish(Yii::app()->controller->createUrl("headline",array("id"=>$data->article_id)), $data->headline, 9)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Phrase::trans(588,0),
						0=>Phrase::trans(589,0),
					),
					'type' => 'raw',
				);
			}
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->article_id)), $data->publish, 1)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Phrase::trans(588,0),
						0=>Phrase::trans(589,0),
					),
					'type' => 'raw',
				);
			}
		}
		parent::afterConstruct();
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		$controller = strtolower(Yii::app()->controller->id);
		if(parent::beforeValidate()) {
			if($this->article_type != 4 && $this->title == '') {
				$this->addError('title', Phrase::trans(26047,1));
			}
			if($this->article_type == 2 && $this->video == '') {
				$this->addError('video', Phrase::trans(26048,1));
			}
			if($this->article_type == 4) {
				if($this->quote == '') {
					$this->addError('quote', Phrase::trans(26114,1));
				}
				if($this->body == '') {
					$this->addError('body', Phrase::trans(26115,1));
				}
			}
			if($this->isNewRecord) {
				$this->user_id = Yii::app()->user->id;			
			}
			if($this->headline == 1 && $this->publish == 0) {
				$this->addError('publish', Phrase::trans(340,0));
			}
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$this->published_date = date('Y-m-d', strtotime($this->published_date));
		}
		return true;
	}
	
	/**
	 * After save attributes
	 */
	protected function afterSave() {
		parent::afterSave();

		$article_path = "public/article/".$this->article_id;

		if($this->isNewRecord && in_array($this->article_type, array(1,3))) {
			// Add article directory
			if(!file_exists($article_path)) {
				@mkdir($article_path, 0777, true);

				// Add file in article directory (index.php)
				$newFile = $article_path.'/index.php';
				$FileHandle = fopen($newFile, 'w');
			}
		}

		if($this->article_type == 1) {
			if($this->isNewRecord || (!$this->isNewRecord && ArticleSetting::getInfo('media_limit') == 1)) {
				$this->media = CUploadedFile::getInstance($this, 'media');
				if($this->media instanceOf CUploadedFile) {
					$fileName = time().'_'.$this->article_id.'.'.strtolower($this->media->extensionName);
					if($this->media->saveAs($article_path.'/'.$fileName)) {
						if($this->isNewRecord || (!$this->isNewRecord && $this->media_id == 0)) {
							$images = new ArticleMedia;
							$images->article_id = $this->article_id;
							$images->cover = 1;
							$images->media = $fileName;
							$images->save();
						} else {
							rename($article_path.'/'.$this->old_media, 'public/article/verwijderen/'.$this->article_id.'_'.$this->old_media);
							$images = ArticleMedia::model()->findByPk($this->media_id);
							$images->media = $fileName;
							$images->update();
						}
					}
				}
			}

		} else if($this->article_type == 2) {
			if($this->isNewRecord) {
				$video = new ArticleMedia;
				$video->article_id = $this->article_id;
				$video->cover = 1;
				$video->media = $this->video;
				$video->save();
			} else {
				if($this->media_id == 0) {
					$video = new ArticleMedia;
					$video->article_id = $this->article_id;
					$video->cover = 1;
					$video->media = $this->video;
					if($video->save()) {
						$data = Articles::model()->findByPk($this->article_id);
						$data->media_id = $video->media_id;
						$data->update();
					}
				} else {
					$video = ArticleMedia::model()->findByPk($this->media_id);
					$video->media = $this->video;
					$video->update();
				}
			}

		} else if($this->article_type == 3) {
			$this->audio = CUploadedFile::getInstance($this, 'audio');
			if($this->audio instanceOf CUploadedFile) {
				$fileName = time().'_'.$this->article_id.'.'.strtolower($this->audio->extensionName);
				if($this->audio->saveAs($article_path.'/'.$fileName)) {
					if($this->isNewRecord || (!$this->isNewRecord && $this->media_id != 0)) {
						$audio = new ArticleMedia;
						$audio->article_id = $this->article_id;
						$audio->cover = 1;
						$audio->media = $fileName;
						$audio->save();

					} else {
						rename($article_path.'/'.$this->old_media, 'public/article/verwijderen/'.$this->article_id.'_'.$this->old_media);
						$audio = ArticleMedia::model()->findByPk($this->media_id);
						$audio->media = $fileName;
						$audio->update();
					}
				}
			}
		}
		
		// Add Keyword
		if(!$this->isNewRecord) {
			if($this->keyword != '') {
				$model = OmmuTags::model()->find(array(
					'select' => 'tag_id, body',
					'condition' => 'publish = 1 AND body = :body',
					'params' => array(
						':body' => $this->keyword,
					),
				));
				$tag = new ArticleTag;
				$tag->article_id = $this->article_id;
				if($model != null) {
					$tag->tag_id = $model->tag_id;
				} else {
					$data = new OmmuTags;
					$data->body = $this->keyword;
					if($data->save()) {
						$tag->tag_id = $data->tag_id;
					}
				}
				$tag->save();
			}			
		}
		
		// Reset headline
		if(ArticleSetting::getInfo('headline') == 1) {
			if($this->headline == 1) {
				self::model()->updateAll(array(
					'headline' => 0,	
				), array(
					'condition'=> 'article_id != :id AND cat_id = :cat',
					'params'=>array(
						':id'=>$this->article_id,
						':cat'=>$this->cat_id,
					),
				));
			}
		} else {
			
		}
	}

	/**
	 * Before delete attributes
	 */
	protected function beforeDelete() {
		if(parent::beforeDelete()) {
			$article_photo = ArticleMedia::getPhoto($this->article_id);
			$article_path = "public/article/".$this->article_id;
			foreach($article_photo as $val) {
				if(in_array($this->article_type, array(1,3)) && $val->media != '')
					rename($article_path.'/'.$val->media, 'public/article/verwijderen/'.$val->article_id.'_'.$val->media);
			}
		}
		return true;			
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() {
		parent::afterDelete();
		//delete article image
		$article_path = "public/article/".$this->article_id;
		Utility::deleteFolder($article_path);		
	}

}