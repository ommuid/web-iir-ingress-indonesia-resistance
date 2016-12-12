<?php
/**
 * Banners
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Banner
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
 * This is the model class for table "ommu_banners".
 *
 * The followings are the available columns in table 'ommu_banners':
 * @property string $banner_id
 * @property integer $publish
 * @property integer $cat_id
 * @property string $user_id
 * @property integer $banner_type
 * @property string $title
 * @property string $url
 * @property string $media
 * @property string $published_date
 * @property string $expired_date
 * @property integer $view
 * @property integer $click
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuBannerCategory $cat
 */
class Banners extends CActiveRecord
{
	public $defaultColumns = array();
	public $permanent;
	public $old_media;
	
	// Variable Search
	public $creation_search;
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Banners the static model class
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
		return 'ommu_banners';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cat_id, title, url, published_date, expired_date', 'required'),
			array('publish, cat_id, banner_type, view, click,
				permanent', 'numerical', 'integerOnly'=>true),
			array('user_id, creation_id, modified_id', 'length', 'max'=>11),
			array('title', 'length', 'max'=>64),
			array('media, user_id, view, click, creation_date, creation_id, modified_date, modified_id,
				permanent, old_media', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('banner_id, publish, cat_id, user_id, banner_type, title, url, media, published_date, expired_date, view, click, creation_date, creation_id, modified_date, modified_id,
				creation_search, modified_search', 'safe', 'on'=>'search'),
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
			'category_relation' => array(self::BELONGS_TO, 'BannerCategory', 'cat_id'),
			'creation_relation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified_relation' => array(self::BELONGS_TO, 'Users', 'modified_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'banner_id' => Yii::t('attribute', 'Banner'),
			'publish' => Yii::t('attribute', 'Publish'),
			'cat_id' => Yii::t('attribute', 'Category'),
			'user_id' => Yii::t('attribute', 'User'),
			'banner_type' => Yii::t('attribute', 'Banner Type'),
			'title' => Yii::t('attribute', 'Title'),
			'url' => Yii::t('attribute', 'Banner Link'),
			'media' => Yii::t('attribute', 'Media'),
			'published_date' => Yii::t('attribute', 'Published Date'),
			'expired_date' => Yii::t('attribute', 'Expired Date'),
			'view' => Yii::t('attribute', 'View'),
			'click' => Yii::t('attribute', 'Click'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'permanent' => Yii::t('attribute', 'Permanent'),
			'old_media' => Yii::t('attribute', 'Old Media'),
			'creation_search' => Yii::t('attribute', 'Creation'),
			'modified_search' => Yii::t('attribute', 'Modified'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.banner_id',$this->banner_id,true);
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
		if(isset($_GET['category']))
			$criteria->compare('t.cat_id',$_GET['category']);
		else
			$criteria->compare('t.cat_id',$this->cat_id);
		if(isset($_GET['user']))
			$criteria->compare('t.user_id',$_GET['user']);
		else
			$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.banner_type',$this->banner_type);
		$criteria->compare('t.title',$this->title,true);
		$criteria->compare('t.url',$this->url,true);
		$criteria->compare('t.media',$this->media,true);
		if($this->published_date != null && !in_array($this->published_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.published_date)',date('Y-m-d', strtotime($this->published_date)));
		if($this->expired_date != null && !in_array($this->expired_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.expired_date)',date('Y-m-d', strtotime($this->expired_date)));
		$criteria->compare('t.view',$this->view);
		$criteria->compare('t.click',$this->click);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_id',$this->creation_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id',$this->modified_id);
		
		// Custom Search
		$criteria->with = array(
			'creation_relation' => array(
				'alias'=>'creation_relation',
				'select'=>'displayname'
			),
			'modified_relation' => array(
				'alias'=>'modified_relation',
				'select'=>'displayname'
			),
		);
		$criteria->compare('creation_relation.displayname',strtolower($this->creation_search), true);
		$criteria->compare('modified_relation.displayname',strtolower($this->modified_search), true);

		if(!isset($_GET['Banners_sort']))
			$criteria->order = 't.banner_id DESC';

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
		} else {
			//$this->defaultColumns[] = 'banner_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'cat_id';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'banner_type';
			$this->defaultColumns[] = 'title';
			$this->defaultColumns[] = 'url';
			$this->defaultColumns[] = 'media';
			$this->defaultColumns[] = 'published_date';
			$this->defaultColumns[] = 'expired_date';
			$this->defaultColumns[] = 'view';
			$this->defaultColumns[] = 'click';
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
				'value' => '$data->url != "-" ? CHtml::link($data->title, $data->url, array(\'target\' => \'_blank\')) : $data->title',
				'type' => 'raw',
			);
			if(!isset($_GET['category'])) {
				$this->defaultColumns[] = array(
					'name' => 'cat_id',
					'value' => 'Phrase::trans($data->category_relation->name, 2)',
					'filter'=> BannerCategory::getCategory(),
					'type' => 'raw',
				);
			}
			/*
			$this->defaultColumns[] = array(
				'name' => 'media',
				'value' => '$data->media != "" ? CHtml::link($data->media, Yii::app()->request->baseUrl.\'/public/banner/\'.$data->media, array(\'target\' => \'_blank\')) : "-"',
				'type' => 'raw',
			);
			*/
			$this->defaultColumns[] = array(
				'name' => 'click',
				'value' => '$data->url != "-" ? $data->click : "-"',
				'htmlOptions' => array(
					'class' => 'center',
				),	
			);
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
			$this->defaultColumns[] = array(
				'name' => 'expired_date',
				'value' => '!in_array($data->expired_date, array("0000-00-00","1970-01-01")) ? Utility::dateFormat($data->expired_date) : "Permanent"',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'expired_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'expired_date_filter',
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
			/* $this->defaultColumns[] = array(
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
			); */
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->banner_id)), $data->publish, 1)',
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
	 * User get information
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
	 * Get Article
	 */
	public static function getBanner($id, $type=null) {
		$criteria=new CDbCriteria;
		$criteria->compare('cat_id',$id);
		
		if($type == null) {
			//$criteria->select = '';
			$model = Banners::model()->findAll($criteria);
		} else {
			$model = Banners::model()->count($criteria);
		}
		
		return $model;
	}

	/**
	 * Get Article
	 */
	public static function resizeBanner($media, $size) {
		Yii::import('ext.phpthumb.PhpThumbFactory');
		$bannerImg = PhpThumbFactory::create($media, array('jpegQuality' => 90, 'correctPermissions' => true));
		$resizeSize = explode(',', $size);
		$bannerImg->adaptiveResize($resizeSize[0], $resizeSize[1]);					
		$bannerImg->save($media);
		
		return true;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		$controller = strtolower(Yii::app()->controller->id);
		if(parent::beforeValidate()) {	
			if($this->isNewRecord) {
				//if(self::getBanner($this->cat_id, 'count') >= $this->category_relation->limit)
				//	$this->addError('cat_id', Phrase::trans($this->category_relation->name, 2).'" cannot be uploaded. jumlah banner sudah melebihi batas maksimal (limit).');
				
				//$this->orders = 0;
				$this->user_id = Yii::app()->user->id;		
			} else
				$this->modified_id = Yii::app()->user->id;
			
			$media = CUploadedFile::getInstance($this, 'media');
			if($media->name != '') {
				$extension = pathinfo($media->name, PATHINFO_EXTENSION);
				$validation = 0;
				if(BannerSetting::getInfo(1, 'media_validation') == 1) {
					$validation = 1;
					$size = getimagesize($media->tempName);
					$bannerSize = explode(',', $this->category_relation->media_size);					
				}
				if(!in_array(strtolower($extension), array('bmp','gif','jpg','png')))
					$this->addError('media', 'The file "'.$media->name.'" cannot be uploaded. Only files with these extensions are allowed: bmp, gif, jpg, png.');
				else {
					if($validation == 1 && $bannerSize[0] != $size[0] && $bannerSize[1] != $size[1])
						$this->addError('media', 'The file "'.$media->name.'" cannot be uploaded. ukuran banner ('.$size[0].' x '.$size[1].') tidak sesuai dengan kategori ('.$bannerSize[0].' x '.$bannerSize[1].')');					
				}				
			} else {
				if($this->isNewRecord)
					$this->addError('media', 'Media cannot be blank.');
			}
			
			if(in_array(date('Y-m-d', strtotime($this->expired_date)), array('00-00-0000','01-01-1970')))
				$this->permanent = 1;
			
			if($this->permanent == 1)
				$this->expired_date = '00-00-0000';
			
			if($this->permanent != 1 && ($this->published_date != '' && $this->expired_date != '') && ($this->published_date >= $this->expired_date))
				$this->addError('expired_date', Yii::t('attribute', 'Expired lebih kecil'));
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {			
			$action = strtolower(Yii::app()->controller->action->id);
			if(!$this->isNewRecord && $action == 'edit') {
				//Update banner photo
				$banner_path = "public/banner";
				// Add directory
				if(!file_exists($banner_path)) {
					@mkdir($banner_path, 0755, true);

					// Add file in directory (index.php)
					$newFile = $banner_path.'/index.php';
					$FileHandle = fopen($newFile, 'w');
				} else
					@chmod($banner_path, 0755, true);
				
				$this->media = CUploadedFile::getInstance($this, 'media');
				if($this->media instanceOf CUploadedFile) {
					$fileName = $this->banner_id.'_'.time().'_'.Utility::getUrlTitle($this->title).'.'.strtolower($this->media->extensionName);
					if($this->media->saveAs($banner_path.'/'.$fileName)) {
						if(BannerSetting::getInfo(1, 'media_resize') == 1)
							self::resizeBanner($banner_path.'/'.$fileName, $this->category_relation->media_size);
						if($this->old_media != '' && file_exists($banner_path.'/'.$this->old_media))
							rename($banner_path.'/'.$this->old_media, 'public/banner/verwijderen/'.$this->banner_id.'_'.$this->old_media);
						$this->media = $fileName;
					}
				}
					
				if($this->media == '')
					$this->media = $this->old_media;
			}
			$this->published_date = date('Y-m-d', strtotime($this->published_date));
			$this->expired_date = date('Y-m-d', strtotime($this->expired_date));
		}
		return true;
	}
	
	/**
	 * After save attributes
	 */
	protected function afterSave() {
		parent::afterSave();
		
		if($this->isNewRecord) {
			$banner_path = "public/banner";
			// Add directory
			if(!file_exists($banner_path)) {
				@mkdir($banner_path, 0755, true);

				// Add file in directory (index.php)
				$newFile = $banner_path.'/index.php';
				$FileHandle = fopen($newFile, 'w');
			} else
				@chmod($banner_path, 0755, true);
			
			$this->media = CUploadedFile::getInstance($this, 'media');
			if($this->media instanceOf CUploadedFile) {
				$fileName = $this->banner_id.'_'.time().'_'.Utility::getUrlTitle($this->title).'.'.strtolower($this->media->extensionName);
				if($this->media->saveAs($banner_path.'/'.$fileName)) {
					if(BannerSetting::getInfo(1, 'media_resize') == 1)
						self::resizeBanner($banner_path.'/'.$fileName, $this->category_relation->media_size);
					Banners::model()->updateByPk($this->banner_id, array('media'=>$fileName));
				}
			}
		}
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() {
		parent::afterDelete();
		//delete article image
		$banner_path = "public/banner";
		if($this->media != '' && file_exists($banner_path.'/'.$this->media))
			rename($banner_path.'/'.$this->media, 'public/banner/verwijderen/'.$this->banner_id.'_'.$this->media);
	}

}