<?php
/**
 * Articles
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Articles
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
 * @property string $media_file
 * @property string $published_date
 * @property integer $comment
 * @property integer $likes
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuArticleComment[] $ommuArticleComments
 * @property OmmuArticleMedia[] $ommuArticleMedias
 * @property OmmuArticleCategory $cat
 */
class Articles extends CActiveRecord
{
	public $defaultColumns = array();
	public $media_input;
	public $old_media_input;
	public $video_input;
	public $keyword;
	public $old_media_file;
	
	// Variable Search
	public $user_search;
	public $creation_search;
	public $modified_search;

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
			array('publish, cat_id, user_id, media_id, headline, comment_code, comment, likes, creation_id, modified_id', 'numerical', 'integerOnly'=>true),
			array('user_id, media_id', 'length', 'max'=>11),
			array('
				video_input, keyword', 'length', 'max'=>32),
			array('title', 'length', 'max'=>128),
			//array('media_input', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			array('media_id, title, body, quote, published_date, creation_date, modified_date, 
				media_input, old_media_input, video_input, keyword, old_media_file', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('article_id, publish, cat_id, user_id, media_id, headline, comment_code, article_type, title, body, quote, media_file, published_date, comment, likes, creation_date, creation_id, modified_date, modified_id,
				user_search, creation_search, modified_search', 'safe', 'on'=>'search'),
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
			'view' => array(self::BELONGS_TO, 'ViewArticles', 'article_id'),
			'cat' => array(self::BELONGS_TO, 'ArticleCategory', 'cat_id'),
			'cover' => array(self::BELONGS_TO, 'ArticleMedia', 'media_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'creation_relation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified_relation' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			'medias' => array(self::HAS_MANY, 'ArticleMedia', 'article_id'),
			'tags' => array(self::HAS_MANY, 'ArticleTag', 'article_id'),
			'tag_ONE' => array(self::HAS_ONE, 'ArticleTag', 'article_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'article_id' => Yii::t('attribute', 'Article'),
			'publish' => Yii::t('attribute', 'Publish'),
			'cat_id' => Yii::t('attribute', 'Category'),
			'user_id' => Yii::t('attribute', 'User'),
			'media_id' => Yii::t('attribute', 'Media'),
			'headline' => Yii::t('attribute', 'Headline'),
			'comment_code' => Yii::t('attribute', 'Comment'),
			'article_type' => Yii::t('attribute', 'Article Type'),
			'title' => Yii::t('attribute', 'Title'),
			'body' => Yii::t('attribute', 'Article'),
			'quote' => Yii::t('attribute', 'Quote'),
			'media_file' => Yii::t('attribute', 'File (Download)'),
			'published_date' => Yii::t('attribute', 'Published Date'),
			'comment' => Yii::t('attribute', 'Comment'),
			'likes' => Yii::t('attribute', 'Likes'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'media_input' => Yii::t('attribute', 'Media').' (Photo)',
			'old_media_input' => Yii::t('attribute', 'Old Media').' (Photo)',
			'video_input' => Yii::t('attribute', 'Video'),
			//'audio' => Yii::t('attribute', 'Audio'),
			'keyword' => Yii::t('attribute', 'Keyword'),
			'old_media_file' => Yii::t('attribute', 'Old File (Download)'),
			'user_search' => Yii::t('attribute', 'User'),
			'creation_search' => Yii::t('attribute', 'Creation'),
			'modified_search' => Yii::t('attribute', 'Modified'),
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
		
		// Custom Search
		$criteria->with = array(
			'user' => array(
				'alias'=>'user',
				'select'=>'displayname',
			),
			'creation_relation' => array(
				'alias'=>'creation_relation',
				'select'=>'displayname',
			),
			'modified_relation' => array(
				'alias'=>'modified_relation',
				'select'=>'displayname',
			),
		);

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
			$category = ArticleCategory::model()->findByPk($_GET['category']);
			if($category->dependency == 0) {
				$parent = $_GET['category'];
				$categoryFind = ArticleCategory::model()->findAll(array(
					'condition' => 'dependency = :dependency',
					'params' => array(
						':dependency' => $parent,
					),
				));
				$items = array();
				$items[] = $_GET['category'];
				if($categoryFind != null) {
					foreach($categoryFind as $key => $val)
						$items[] = $val->cat_id;
				}
				$criteria->addInCondition('t.cat_id',$items);
				
			} else
				$criteria->compare('t.cat_id',$_GET['category']);
		} else
			$criteria->compare('t.cat_id',$this->cat_id);
		
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.media_id',$this->media_id);
		$criteria->compare('t.headline',$this->headline);
		$criteria->compare('t.comment_code',$this->comment_code);
		$criteria->compare('t.article_type',$this->article_type);
		$criteria->compare('t.title',strtolower($this->title),true);
		$criteria->compare('t.body',strtolower($this->body),true);
		$criteria->compare('t.quote',strtolower($this->quote),true);
		$criteria->compare('t.media_file',strtolower($this->media_file),true);
		if($this->published_date != null && !in_array($this->published_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.published_date)',date('Y-m-d', strtotime($this->published_date)));
		$criteria->compare('t.comment',$this->comment);
		$criteria->compare('t.likes',$this->likes);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_id',$this->creation_id);
		
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id',$this->modified_id);
		
		$criteria->compare('user.displayname',strtolower($this->user_search), true);
		$criteria->compare('creation_relation.displayname',strtolower($this->creation_search), true);
		$criteria->compare('modified_relation.displayname',strtolower($this->modified_search), true);

		if(!isset($_GET['Articles_sort']))
			$criteria->order = 't.article_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>$controller != 'regulation/site' ? 30: 8,
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
			$this->defaultColumns[] = 'media_file';
			$this->defaultColumns[] = 'published_date';
			$this->defaultColumns[] = 'comment';
			$this->defaultColumns[] = 'likes';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_id';
			$this->defaultColumns[] = 'modified_date';
			$this->defaultColumns[] = 'modified_id';
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
			$category = ArticleCategory::model()->findByPk($_GET['category']);
			if(!isset($_GET['category']) || (isset($_GET['category']) && $category->dependency == 0)) {
				if($category->dependency == 0)
					$parent = $_GET['category'];
				else
					$parent = null;
				$this->defaultColumns[] = array(
					'name' => 'cat_id',
					'value' => 'Phrase::trans($data->cat->name, 2)',
					'filter'=> ArticleCategory::getCategory(null, $parent),
					'type' => 'raw',
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'creation_search',
				'value' => '$data->creation_relation->displayname',
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
			if(in_array($controller, array('o/admin'))) {
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
			if(!isset($_GET['type'])) {
				if(OmmuSettings::getInfo('site_headline') == 1) {
					$this->defaultColumns[] = array(
						'name' => 'headline',
						'value' => '$data->headline == 1 ? Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Utility::getPublish(Yii::app()->controller->createUrl("headline",array("id"=>$data->article_id)), $data->headline, 9)',
						'htmlOptions' => array(
							'class' => 'center',
						),
						'filter'=>array(
							1=>Yii::t('phrase', 'Yes'),
							0=>Yii::t('phrase', 'No'),
						),
						'type' => 'raw',
					);
				}
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->article_id)), $data->publish, 1)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Yii::t('phrase', 'Yes'),
						0=>Yii::t('phrase', 'No'),
					),
					'type' => 'raw',
				);
			}
		}
		parent::afterConstruct();
	}

	/**
	 * Articles get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::model()->findByPk($id,array(
				'select' => $column
			));
			return $model->$column;
			
		} else {
			$model = self::model()->findByPk($id);
			return $model;			
		}
	}

	/**
	 * Albums get information
	 */
	public function searchIndexing($index)
	{
		Yii::import('application.modules.article.models.*');
		
		$criteria=new CDbCriteria;
		$criteria->compare('t.publish', 1);
		$criteria->compare('date(t.published_date) <', date('Y-m-d H:i:s'));
		$criteria->order = 't.article_id DESC';
		//$criteria->limit = 10;
		$model = Articles::model()->findAll($criteria);
		foreach($model as $key => $item) {
			$medias = $item->medias;
			if($medias != null)
				$images = Yii::app()->request->baseUrl.'/public/article/'.$item->article_id.'/'.$medias[0]->media;
			else
				$images = '';
			$url = Yii::app()->createUrl('article/site/view', array('id'=>$item->article_id,'t'=>Utility::getUrlTitle($item->title)));
				
			$doc = new Zend_Search_Lucene_Document();
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('id', CHtml::encode($item->article_id), 'utf-8')); 
			$doc->addField(Zend_Search_Lucene_Field::Keyword('category', CHtml::encode(Phrase::trans($item->cat->name,2)), 'utf-8'));
			$doc->addField(Zend_Search_Lucene_Field::Text('media', CHtml::encode($images), 'utf-8'));
			$doc->addField(Zend_Search_Lucene_Field::Text('title', CHtml::encode($item->title), 'utf-8'));
			$doc->addField(Zend_Search_Lucene_Field::Text('body', CHtml::encode(Utility::hardDecode(Utility::softDecode($item->body))), 'utf-8'));
			$doc->addField(Zend_Search_Lucene_Field::Text('url', CHtml::encode(Utility::getProtocol().'://'.Yii::app()->request->serverName.$url), 'utf-8'));
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('date', CHtml::encode($item->published_date), 'utf-8'));
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('creation', CHtml::encode($item->user->displayname), 'utf-8'));
			$index->addDocument($doc);			
		}
		
		return true;
	}

	/**
	 * User get information
	 */
	public static function getShareUrl($id, $t=null)
	{
		if($t != null && $t != '' && $t != '-')
			return Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->controller->createUrl('site/view', array('id'=>$id, 't'=>Utility::getUrlTitle($t)));
		else
			return Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->controller->createUrl('site/view', array('id'=>$id));
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		$controller = strtolower(Yii::app()->controller->id);			
		$setting = ArticleSetting::model()->findByPk(1, array(
			'select' => 'media_file_type, upload_file_type',
		));
		$media_file_type = unserialize($setting->media_file_type);
		$upload_file_type = unserialize($setting->upload_file_type);
		
		if(parent::beforeValidate()) {
			if($this->article_type != 4 && $this->title == '')
				$this->addError('title', Yii::t('phrase', 'Title cannot be blank.'));
			
			if($this->article_type == 2 && $this->video_input == '')
				$this->addError('video_input', Yii::t('phrase', 'Video cannot be blank.'));
			
			if($this->article_type == 4) {
				if($this->body == '')
					$this->addError('body', Yii::t('phrase', 'Article cannot be blank.'));
			}

			if($this->headline == 1 && $this->publish == 0)
				$this->addError('publish', Yii::t('phrase', 'Publish cannot be blank.'));
			
			$media_input = CUploadedFile::getInstance($this, 'media_input');
			if($this->article_type == 1 && $media_input->name != '') {
				$extension = pathinfo($media_input->name, PATHINFO_EXTENSION);
				if(!in_array(strtolower($extension), $media_file_type))
					$this->addError('media_input', Yii::t('phrase', 'The file {name} cannot be uploaded. Only files with these extensions are allowed: {extensions}.', array(
						'{name}'=>$media_input->name,
						'{extensions}'=>Utility::formatFileType($media_file_type, false),
					)));
			}
			
			$media_file = CUploadedFile::getInstance($this, 'media_file');
			if($media_file->name != '') {
				$extension = pathinfo($media_file->name, PATHINFO_EXTENSION);
				if(!in_array(strtolower($extension), $upload_file_type))
					$this->addError('media_file', Yii::t('phrase', 'The file {name} cannot be uploaded. Only files with these extensions are allowed: {extensions}.', array(
						'{name}'=>$media_file->name,
						'{extensions}'=>Utility::formatFileType($upload_file_type, false),
					)));
			}
			
			if($this->isNewRecord)
				$this->user_id = Yii::app()->user->id;
			else
				$this->modified_id = Yii::app()->user->id;
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		$action = strtolower(Yii::app()->controller->action->id);
		
		if(parent::beforeSave()) {
			if(!$this->isNewRecord && $action == 'edit') {
				$article_path = "public/article/".$this->article_id;
				if(!in_array($this->article_type, array(4))) {
					// Add directory
					if(!file_exists($article_path)) {
						@mkdir($article_path, 0755, true);

						// Add file in directory (index.php)
						$newFile = $article_path.'/index.php';
						$FileHandle = fopen($newFile, 'w');
					} else
						@chmod($article_path, 0755, true);
				}
				
				$this->media_file = CUploadedFile::getInstance($this, 'media_file');
				if($this->media_file instanceOf CUploadedFile) {
					$fileName = time().'_'.Utility::getUrlTitle($this->title).'.'.strtolower($this->media_file->extensionName);
					if($this->media_file->saveAs($article_path.'/'.$fileName)) {
						if($this->old_media_file != '' && file_exists($article_path.'/'.$this->old_media_file))
							rename($article_path.'/'.$this->old_media_file, 'public/article/verwijderen/'.$this->article_id.'_'.$this->old_media_file);
						$this->media_file = $fileName;
					}
				}
					
				if($this->media_file == '')
					$this->media_file = $this->old_media_file;
			}
			
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

		if($this->isNewRecord) {
			if(!in_array($this->article_type, array(4))) {
				// Add directory
				if(!file_exists($article_path)) {
					@mkdir($article_path, 0755, true);

					// Add file in directory (index.php)
					$newFile = $article_path.'/index.php';
					$FileHandle = fopen($newFile, 'w');
				} else
					@chmod($article_path, 0755, true);
			}
			
			//upload media file (download)
			$this->media_file = CUploadedFile::getInstance($this, 'media_file');
			if($this->media_file instanceOf CUploadedFile) {
				$fileName = time().'_'.Utility::getUrlTitle($this->title).'.'.strtolower($this->media_file->extensionName);
				if($this->media_file->saveAs($article_path.'/'.$fileName))
					Articles::model()->updateByPk($this->article_id, array('media_file'=>$fileName));
			}
			
		} else {
			// Add Keyword
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

		if($this->article_type == 1) {
			if($this->isNewRecord || (!$this->isNewRecord && ArticleSetting::getInfo('media_limit') == 1)) {
				$this->media_input = CUploadedFile::getInstance($this, 'media_input');
				if($this->media_input instanceOf CUploadedFile) {
					$fileName = time().'_'.Utility::getUrlTitle($this->title).'.'.strtolower($this->media_input->extensionName);
					if($this->media_input->saveAs($article_path.'/'.$fileName)) {
						if($this->isNewRecord || (!$this->isNewRecord && $this->media_id == 0)) {
							$images = new ArticleMedia;
							$images->article_id = $this->article_id;
							$images->cover = 1;
							$images->media = $fileName;
							$images->save();
						} else {
							if($this->old_media_input != '' && file_exists($article_path.'/'.$this->old_media_input))
								rename($article_path.'/'.$this->old_media_input, 'public/article/verwijderen/'.$this->article_id.'_'.$this->old_media_input);
							ArticleMedia::model()->updateByPk($this->media_id, array('media'=>$fileName));
						}
					}
				}
			}

		} else if($this->article_type == 2) {
			if($this->isNewRecord) {
				$video = new ArticleMedia;
				$video->article_id = $this->article_id;
				$video->cover = 1;
				$video->media = $this->video_input;
				$video->save();
			} else {
				if($this->media_id == 0) {
					$video = new ArticleMedia;
					$video->article_id = $this->article_id;
					$video->cover = 1;
					$video->media = $this->video_input;
					if($video->save())
						Articles::model()->updateByPk($this->article_id, array('media_id'=>$video->media_id));
					
				} else
					ArticleMedia::model()->updateByPk($this->media_id, array('media'=>$this->video_input));
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
		}
	}

	/**
	 * Before delete attributes
	 */
	protected function beforeDelete() {
		if(parent::beforeDelete()) {
			$article_path = "public/article/".$this->article_id;
			
			//delete media photos
			$article_photo = ArticleMedia::getPhoto($this->article_id);
			foreach($article_photo as $val) {
				if(in_array($this->article_type, array(1,3)) && $val->media != '' && file_exists($article_path.'/'.$val->media))
					rename($article_path.'/'.$val->media, 'public/article/verwijderen/'.$val->article_id.'_'.$val->media);
			}
			//delete media file
			if($this->media_file != '' && file_exists($article_path.'/'.$val->media_file))
				rename($article_path.'/'.$val->media_file, 'public/article/verwijderen/'.$val->article_id.'_'.$val->media_file);
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