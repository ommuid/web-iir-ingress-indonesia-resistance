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
 * This is the model class for table "ommu_article_media".
 *
 * The followings are the available columns in table 'ommu_article_media':
 * @property string $media_id
 * @property string $article_id
 * @property integer $orders
 * @property integer $cover
 * @property string $media
 * @property string $creation_date
 *
 * The followings are the available model relations:
 * @property OmmuArticles $article
 */
class ArticleMedia extends CActiveRecord
{
	public $defaultColumns = array();
	public $old_media;
	public $video;
	public $audio;
	
	// Variable Search
	public $article_search;
	public $type_search;
	
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
			array('orders, cover', 'numerical', 'integerOnly'=>true),
			array('article_id', 'length', 'max'=>11),
			array('
				video', 'length', 'max'=>32),
			array('media,
				old_media, audio', 'length', 'max'=>64),
			array('media', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			array('audio', 'file', 'types' => 'mp3, mp4', 'maxSize'=>7097152, 'allowEmpty' => true),
			array('cover, media, creation_date,
				old_media, video, audio', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('media_id, article_id, orders, cover, media, creation_date,
				article_search, type_search', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'media_id' => Phrase::trans(26039,1),
			'article_id' => Phrase::trans(26000,1),
			'orders' => Phrase::trans(26072,1),
			'cover' => Phrase::trans(26073,1),
			'media' => Phrase::trans(26039,1),
			'creation_date' => Phrase::trans(26069,1),
			'old_media' => Phrase::trans(26071,1),
			'video' => Phrase::trans(26044,1),
			'audio' => Phrase::trans(26045,1),
			'article_search' => Phrase::trans(26000,1),
			'type_search' => Phrase::trans(26067,1),
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
		
		// Custom Search
		$criteria->with = array(
			'article' => array(
				'alias'=>'article',
				'select'=>'article_type, title'
			),
		);
		$criteria->compare('article.title',strtolower($this->article_search), true);
		$criteria->compare('article.article_type',strtolower($this->type_search), true);

		if(!isset($_GET['ArticleMedia_sort']))
			//$criteria->order = 'media_id DESC';

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
					'value' => '$data->article->article_type == 1 ? Phrase::trans(26043,1) : ($data->article->article_type == 2 ? Phrase::trans(26044,1) : Phrase::trans(26045,1))',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Phrase::trans(26043,1),
						2=>Phrase::trans(26044,1),
						3=>Phrase::trans(26045,1),
					),
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'media',
				'value' => '$data->article->article_type == 2 ? CHtml::link("http://www.youtube.com/watch?v=".$data->media, "http://www.youtube.com/watch?v=".$data->media, array(\'target\' => \'_blank\')) : CHtml::link($data->media, Yii::app()->request->baseUrl.\'/public/article/\'.$data->article_id.\'/\'.$data->media, array(\'target\' => \'_blank\'))',
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'cover',
				'value' => '$data->cover == 1 ? Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/unpublish.png\')',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>Phrase::trans(588,0),
					0=>Phrase::trans(589,0),
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
			if(!$this->isNewRecord) {
				if($this->article->article_type == 2 && $this->media == '') {
					$this->addError('video', Phrase::trans(26048,1));
				}
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
					
					if($this->article->article_type == 1) {
						$this->media = CUploadedFile::getInstance($this, 'media');
						if($this->media instanceOf CUploadedFile) {
							$fileName = time().'_'.$this->article_id.'.'.strtolower($this->media->extensionName);
							if($this->media->saveAs($article_path.'/'.$fileName)) {
								rename($article_path.'/'.$this->old_media, 'public/article/verwijderen/'.$this->article_id.'_'.$this->old_media);
								$this->media = $fileName;
							}
						}
					} else if($this->article->article_type == 3) {
						$this->audio = CUploadedFile::getInstance($this, 'audio');
						if($this->audio instanceOf CUploadedFile) {
							$fileName = time().'_'.$this->article_id.'.'.strtolower($this->audio->extensionName);
							if($this->audio->saveAs($article_path.'/'.$fileName)) {
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
			$setting = ArticleSetting::getInfo('media_limit, media_resize, media_resize_size, media_large_width, media_large_height', 'many');
			
			//create thumb image
			if($setting->media_resize == 1) {
				Yii::import('ext.phpthumb.PhpThumbFactory');
				$article_path = "public/article/".$this->article_id;
				$articleImg = PhpThumbFactory::create($article_path.'/'.$this->media, array('jpegQuality' => 90, 'correctPermissions' => true));
				$resizeSize = explode(',', $setting->media_resize_size);
				if($resizeSize[1] == 0)
					$articleImg->resize($resizeSize[0]);
				else
					$articleImg->adaptiveResize($resizeSize[0], $resizeSize[1]);
					
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
		if(in_array($this->article->article_type, array(1,3)) && $this->media != '')
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