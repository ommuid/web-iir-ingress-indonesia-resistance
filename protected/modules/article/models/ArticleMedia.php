<?php
/**
 * ArticleMedia
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
 * This is the model class for table "ommu_article_media".
 *
 * The followings are the available columns in table 'ommu_article_media':
 * @property string $media_id
 * @property string $article_id
 * @property integer $orders
 * @property integer $cover
 * @property string $media
 * @property string $creation_date
 * @property string $creation_id
 *
 * The followings are the available model relations:
 * @property OmmuArticles $article
 */
class ArticleMedia extends CActiveRecord
{
	public $defaultColumns = array();
	public $old_media;
	public $video;
	
	// Variable Search
	public $type_search;
	public $article_search;
	public $creation_search;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ArticleMedia the static model class
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
		return 'ommu_article_media';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article_id', 'required'),
			array('orders, cover, creation_id', 'numerical', 'integerOnly'=>true),
			array('article_id', 'length', 'max'=>11),
			array('
				video', 'length', 'max'=>32),
			array('cover, media, caption, creation_date,
				old_media, video', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('media_id, article_id, orders, cover, media, creation_date, creation_id,
				article_search, creation_search, type_search', 'safe', 'on'=>'search'),
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
			'article' => array(self::BELONGS_TO, 'Articles', 'article_id'),
			'creation_relation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'media_id' => Yii::t('attribute', 'Media'),
			'article_id' => Yii::t('attribute', 'Article'),
			'orders' => Yii::t('attribute', 'Orders'),
			'cover' => Yii::t('attribute', 'Cover'),
			'media' => Yii::t('attribute', 'Media'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'old_media' => Yii::t('attribute', 'Old Media'),
			'video' => Yii::t('attribute', 'Video'),
			'type_search' => Yii::t('attribute', 'Article Type'),
			'article_search' => Yii::t('attribute', 'Article'),
			'creation_search' => Yii::t('attribute', 'Creation'),
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		// Custom Search
		$criteria->with = array(
			'article' => array(
				'alias'=>'article',
				'select'=>'article_type, title',
			),
			'creation_relation' => array(
				'alias'=>'creation_relation',
				'select'=>'displayname',
			),
		);

		$criteria->compare('t.media_id',$this->media_id);
		if(isset($_GET['article'])) {
			$criteria->compare('t.article_id',$_GET['article']);
		} else {
			$criteria->compare('t.article_id',$this->article_id);
		}
		$criteria->compare('t.orders',$this->orders);
		$criteria->compare('t.cover',$this->cover);
		$criteria->compare('t.media',strtolower($this->media),true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_id',$this->creation_id);
		
		$criteria->compare('article.article_type',strtolower($this->type_search), true);
		$criteria->compare('article.title',strtolower($this->article_search), true);
		$criteria->compare('creation_relation.displayname',strtolower($this->creation_search), true);

		if(!isset($_GET['ArticleMedia_sort']))
			$criteria->order = 't.media_id DESC';

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
			//$this->defaultColumns[] = 'media_id';
			$this->defaultColumns[] = 'article_id';
			$this->defaultColumns[] = 'orders';
			$this->defaultColumns[] = 'cover';
			$this->defaultColumns[] = 'media';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_id';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			if(!isset($_GET['article'])) {
				$this->defaultColumns[] = array(
					'name' => 'article_search',
					'value' => '$data->article->title."<br/><span>".Utility::shortText(Utility::hardDecode($data->article->body),150)."</span>"',
					'htmlOptions' => array(
						'class' => 'bold',
					),
					'type' => 'raw',
				);
				$this->defaultColumns[] = array(
					'name' => 'type_search',
					'value' => '$data->article->article_type == 1 ? Yii::t(\'attribute\', \'Standard\') : ($data->article->article_type == 2 ? Yii::t(\'attribute\', \'Video\') : Yii::t(\'attribute\', \'Audio\'))',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Yii::t('attribute', 'Standard'),
						2=>Yii::t('attribute', 'Video'),
						3=>Yii::t('attribute', 'Audio'),
					),
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'media',
				'value' => '$data->article->article_type == 2 ? CHtml::link("http://www.youtube.com/watch?v=".$data->media, "http://www.youtube.com/watch?v=".$data->media, array(\'target\' => \'_blank\')) : CHtml::link($data->media, Yii::app()->request->baseUrl.\'/public/article/\'.$data->article_id.\'/\'.$data->media, array(\'target\' => \'_blank\'))',
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_search',
				'value' => '$data->creation_relation->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'cover',
				'value' => '$data->cover == 1 ? Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/unpublish.png\')',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>Yii::t('phrase', 'Yes'),
					0=>Yii::t('phrase', 'No'),
				),
				'type' => 'raw',
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
		}
		parent::afterConstruct();
	}

	/**
	 * ArticleMedia get information
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
	 * get photo product
	 */
	public static function getPhoto($id, $type=null) {
		if($type == null) {
			$model = self::model()->findAll(array(
				//'select' => 'article_id, orders, media',
				'condition' => 'article_id = :id',
				'params' => array(
					':id' => $id,
				),
				'limit' => 20,
			));
		} else {
			$model = self::model()->findAll(array(
				//'select' => 'article_id, orders, media',
				'condition' => 'article_id = :id AND cover = :cover',
				'params' => array(
					':id' => $id,
					':cover' => $type,
				),
				'limit' => 20,
				//'order'=> 'orders ASC',
			));
		}

		return $model;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {		
			$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
			if(!$this->isNewRecord) {
				if($this->article->article_type == 2 && $this->media == '') {
					$this->addError('video', Yii::t('attribute', 'Video cannot be blank.'));
				}
			} else
				$this->creation_id = Yii::app()->user->id;
			
			$media = CUploadedFile::getInstance($this, 'media');
			if($currentAction != 'media/ajaxadd' && $this->article->article_type == 1 && $media->name != '') {
				$extension = pathinfo($media->name, PATHINFO_EXTENSION);
				if(!in_array(strtolower($extension), array('bmp','gif','jpg','png')))
					$this->addError('media', 'The file "'.$media->name.'" cannot be uploaded. Only files with these extensions are allowed: bmp, gif, jpg, png.');
			}
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			
			//Update album photo
			$controller = strtolower(Yii::app()->controller->id);
			if(!$this->isNewRecord && $controller == 'media' && !Yii::app()->request->isAjaxRequest) {
				if(in_array($this->article->article_type, array(1,3))) {
					$article_path = "public/article/".$this->article_id;
					if(!file_exists($article_path)) {
						@mkdir($article_path, 0755, true);

						// Add file in directory (index.php)
						$newFile = $article_path.'/index.php';
						$FileHandle = fopen($newFile, 'w');
					} else
						@chmod($article_path, 0755, true);
					
					if($this->article->article_type == 1) {
						$this->media = CUploadedFile::getInstance($this, 'media');
						if($this->media instanceOf CUploadedFile) {
							$fileName = time().'_'.$this->article_id.'_'.Utility::getUrlTitle($this->article->title).'.'.strtolower($this->media->extensionName);
							if($this->media->saveAs($article_path.'/'.$fileName)) {
								if($this->old_media != '' && file_exists($article_path.'/'.$this->old_media))
									rename($article_path.'/'.$this->old_media, 'public/article/verwijderen/'.$this->article_id.'_'.$this->old_media);
								$this->media = $fileName;
							}
						}
					}
					if($this->media == '') {
						$this->media = $this->old_media;
					}
				} else if($this->article->article_type == 2) {
					$this->media = $this->video;
				}
			}
		}
		return true;
	}
	
	/**
	 * After save attributes
	 */
	protected function afterSave() {
		parent::afterSave();

		//set flex cover in article
		//if($this->cover == 1 || count(self::getPhoto($this->article_id)) == 1) {
		if($this->cover == 1) {
			$cover = Articles::model()->findByPk($this->article_id);
			$cover->media_id = $this->media_id;
			$cover->update();
		}

		if($this->article->article_type == 1) {
			$setting = ArticleSetting::getInfo('media_limit, media_resize, media_resize_size', 'many');
			
			//create thumb image
			if($setting->media_resize == 1) {
				Yii::import('ext.phpthumb.PhpThumbFactory');
				$article_path = "public/article/".$this->article_id;
				if(!file_exists($article_path)) {
					@mkdir($article_path, 0755, true);

					// Add file in directory (index.php)
					$newFile = $article_path.'/index.php';
					$FileHandle = fopen($newFile, 'w');
				} else
					@chmod($article_path, 0755, true);
				
				$articleImg = PhpThumbFactory::create($article_path.'/'.$this->media, array('jpegQuality' => 90, 'correctPermissions' => true));
				$resizeSize = unserialize($setting->media_resize_size);
				if($resizeSize['height'] == 0)
					$articleImg->resize($resizeSize['width']);
				else
					$articleImg->adaptiveResize($resizeSize['width'], $resizeSize['height']);		
				$articleImg->save($article_path.'/'.$this->media);
			}
			
			//delete other media (if media_limit = 1)
			if($setting->media_limit == 1) {
				self::model()->deleteAll(array(
					'condition'=> 'article_id = :id AND cover = :cover',
					'params'=>array(
						':id'=>$this->article_id,
						':cover'=>0,
					),
				));
			}
		}
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() {
		parent::afterDelete();
		//delete article image
		$article_path = "public/article/".$this->article_id;
		if(in_array($this->article->article_type, array(1,3)) && $this->media != '' && file_exists($article_path.'/'.$this->media))
			rename($article_path.'/'.$this->media, 'public/article/verwijderen/'.$this->article_id.'_'.$this->media);

		//reset cover in article
		$data = self::getPhoto($this->article_id);
		if($data != null) {
			if($this->cover == 1) {				
				$photo = self::model()->findByPk($data[0]->media_id);
				$photo->cover = 1;
				if($photo->update()) {
					$cover = Articles::model()->findByPk($this->article_id);
					$cover->media_id = $photo->media_id;
					$cover->update();
				}
			}
		}
	}

}