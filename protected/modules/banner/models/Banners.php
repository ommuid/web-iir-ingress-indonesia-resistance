<?php
/**
 * Banners
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/mod-banner
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
 * @property string $title
 * @property string $url
 * @property string $banner_filename
 * @property string $published_date
 * @property string $expired_date
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
	public $linked_i;
	public $permanent_i;
	public $old_banner_filename_i;
	
	// Variable Search
	public $creation_search;
	public $modified_search;

	/**
	 * Behaviors for this model
	 */
	public function behaviors() 
	{
		return array(
			'sluggable' => array(
				'class'=>'ext.yii-behavior-sluggable.SluggableBehavior',
				'columns' => array('title'),
				'unique' => true,
				'update' => true,
			),
		);
	}

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
			array('publish, cat_id,
				linked_i, permanent_i', 'numerical', 'integerOnly'=>true),
			array('user_id, creation_id, modified_id', 'length', 'max'=>11),
			array('title', 'length', 'max'=>64),
			array('banner_filename, user_id, creation_date, creation_id, modified_date, modified_id,
				linked_i, permanent_i, old_banner_filename_i', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('banner_id, publish, cat_id, user_id, title, url, banner_filename, published_date, expired_date, creation_date, creation_id, modified_date, modified_id,
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
			'view' => array(self::BELONGS_TO, 'ViewBanners', 'banner_id'),
			'category' => array(self::BELONGS_TO, 'BannerCategory', 'cat_id'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			'clicks' => array(self::HAS_MANY, 'BannerClicks', 'banner_id'),
			'views' => array(self::HAS_MANY, 'BannerViews', 'banner_id'),
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
			'title' => Yii::t('attribute', 'Title'),
			'url' => Yii::t('attribute', 'Banner Link'),
			'banner_filename' => Yii::t('attribute', 'Banner (File)'),
			'published_date' => Yii::t('attribute', 'Published Date'),
			'expired_date' => Yii::t('attribute', 'Expired Date'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'linked_i' => Yii::t('attribute', 'Linked'),
			'permanent_i' => Yii::t('attribute', 'Permanent'),
			'old_banner_filename_i' => Yii::t('attribute', 'Old Media'),
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
		
		// Custom Search
		$criteria->with = array(
			'creation' => array(
				'alias'=>'creation',
				'select'=>'displayname'
			),
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname'
			),
		);

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
		$criteria->compare('t.title',$this->title,true);
		$criteria->compare('t.url',$this->url,true);
		$criteria->compare('t.banner_filename',$this->banner_filename,true);
		if($this->published_date != null && !in_array($this->published_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.published_date)',date('Y-m-d', strtotime($this->published_date)));
		if($this->expired_date != null && !in_array($this->expired_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.expired_date)',date('Y-m-d', strtotime($this->expired_date)));
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_id',$this->creation_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id',$this->modified_id);
		
		$criteria->compare('creation.displayname',strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname',strtolower($this->modified_search), true);

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
			$this->defaultColumns[] = 'title';
			$this->defaultColumns[] = 'url';
			$this->defaultColumns[] = 'banner_filename';
			$this->defaultColumns[] = 'published_date';
			$this->defaultColumns[] = 'expired_date';
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
					'value' => 'Phrase::trans($data->category->name)',
					'filter'=> BannerCategory::getCategory(),
					'type' => 'raw',
				);
			}
			/*
			$this->defaultColumns[] = array(
				'name' => 'banner_filename',
				'value' => '$data->banner_filename != "" ? CHtml::link($data->banner_filename, Yii::app()->request->baseUrl.\'/public/banner/\'.$data->banner_filename, array(\'target\' => \'_blank\')) : "-"',
				'type' => 'raw',
			);
			*/
			$this->defaultColumns[] = array(
				'header' => Yii::t('phrase', 'Views'),
				'value' => 'CHtml::link($data->view->views ? $data->view->views : 0, Yii::app()->controller->createUrl("o/view/manage",array(\'banner\'=>$data->banner_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'header' => Yii::t('phrase', 'Clicks'),
				'value' => '$data->url != "-" ? CHtml::link($data->view->clicks ? $data->view->clicks : 0, Yii::app()->controller->createUrl("o/click/manage",array(\'banner\'=>$data->banner_id))) : "-"',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'published_date',
				'value' => 'Utility::dateFormat($data->published_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'published_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
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
				'filter' => Yii::app()->controller->widget('application.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'expired_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
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
				'value' => '$data->creation->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Utility::dateFormat($data->creation_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'creation_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
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
	 * Resize Banner
	 */
	public static function resizeBanner($banner, $resize) {
		Yii::import('ext.phpthumb.PhpThumbFactory');
		$resizeBanner = PhpThumbFactory::create($banner, array('jpegQuality' => 90, 'correctPermissions' => true));
		if($resize['height'] == 0)
			$resizeBanner->resize($resize['width']);
		else			
			$resizeBanner->adaptiveResize($resize['width'], $resize['height']);
		$resizeBanner->save($banner);
		
		return true;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		$controller = strtolower(Yii::app()->controller->id);
		$setting = BannerSetting::model()->findByPk(1, array(
			'select' => 'banner_validation, banner_file_type',
		));
		$banner_file_type = unserialize($setting->banner_file_type);
		if(empty($banner_file_type))
			$banner_file_type = array();
		
		if(parent::beforeValidate()) {	
			if($this->isNewRecord)
				$this->user_id = Yii::app()->user->id;		
			else
				$this->modified_id = Yii::app()->user->id;
			
			$banner_filename = CUploadedFile::getInstance($this, 'banner_filename');
			if($banner_filename != null) {
				$extension = pathinfo($banner_filename->name, PATHINFO_EXTENSION);
				$validation = 0;
				if($setting->banner_validation == 1)
					$validation = 1;
				$fileSize = getimagesize($banner_filename->tempName);
				$bannerSize = unserialize($this->category->banner_size);
				
				if(!in_array(strtolower($extension), $banner_file_type))
					$this->addError('banner_filename', Yii::t('phrase', 'The file {name} cannot be uploaded. Only files with these extensions are allowed: {extensions}.', array(
						'{name}'=>$banner_filename->name,
						'{extensions}'=>Utility::formatFileType($banner_file_type, false),
					)));
				else {
					if($validation == 1 && !($fileSize[0] == $bannerSize['width'] && $fileSize[1] == $bannerSize['height']))
						$this->addError('banner_filename', Yii::t('phrase', 'The file {name} cannot be uploaded. ukuran banner ({file_size}) tidak sesuai dengan kategori ({banner_size})', array(
							'{name}'=>$banner_filename->name,
							'{file_size}'=>$fileSize[0].' x '.$fileSize[1],
							'{banner_size}'=>$bannerSize['width'].' x '.$bannerSize['height'],
						)));
				}				
			} else {
				if($this->isNewRecord && $controller == 'o/admin')
					$this->addError('banner_filename', Yii::t('phrase', 'Banner (File) cannot be blank.'));
			}
			
			if($this->linked_i == 0)
				$this->url = '-';
			
			if(in_array(date('Y-m-d', strtotime($this->expired_date)), array('00-00-0000','01-01-1970')))
				$this->permanent_i = 1;
			
			if($this->permanent_i == 1)
				$this->expired_date = '00-00-0000';
			
			if($this->linked_i == 1 && $this->url == '-')
				$this->addError('url', Yii::t('phrase', 'URL harus dalam format hyperlink'));
			
			if($this->permanent_i != 1 && ($this->published_date != '' && $this->expired_date != '') && ($this->published_date >= $this->expired_date))
				$this->addError('expired_date', Yii::t('phrase', 'Expired lebih kecil'));
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		
		$setting = BannerSetting::model()->findByPk(1, array(
			'select' => 'banner_validation, banner_resize',
		));
		
		if(parent::beforeSave()) {			
			if(!$this->isNewRecord) {
				$banner_path = "public/banner";
				
				// Add directory
				if(!file_exists($banner_path)) {
					@mkdir($banner_path, 0755, true);

					// Add file in directory (index.php)
					$newFile = $banner_path.'/index.php';
					$FileHandle = fopen($newFile, 'w');
				} else
					@chmod($banner_path, 0755, true);
				
				$this->banner_filename = CUploadedFile::getInstance($this, 'banner_filename');
				if($this->banner_filename != null) {
					if($this->banner_filename instanceOf CUploadedFile) {
						$fileName = time().'_'.$this->banner_id.'_'.Utility::getUrlTitle($this->title).'.'.strtolower($this->banner_filename->extensionName);
						if($this->banner_filename->saveAs($banner_path.'/'.$fileName)) {							
							if($this->old_banner_filename_i != '' && file_exists($banner_path.'/'.$this->old_banner_filename_i))
								rename($banner_path.'/'.$this->old_banner_filename_i, 'public/banner/verwijderen/'.$this->banner_id.'_'.$this->old_banner_filename_i);
							$this->banner_filename = $fileName;
							
							if($setting->banner_validation == 0 && $setting->banner_resize == 1)
								self::resizeBanner($banner_path.'/'.$fileName, unserialize($this->category->banner_size));
						}
					}
				} else {
					if($this->banner_filename == '')
						$this->banner_filename = $this->old_banner_filename_i;
				}
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
		
		$setting = BannerSetting::model()->findByPk(1, array(
			'select' => 'banner_validation, banner_resize',
		));
		
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
			
			$this->banner_filename = CUploadedFile::getInstance($this, 'banner_filename');
			if($this->banner_filename != null) {
				if($this->banner_filename instanceOf CUploadedFile) {
					$fileName = time().'_'.$this->banner_id.'_'.Utility::getUrlTitle($this->title).'.'.strtolower($this->banner_filename->extensionName);
					if($this->banner_filename->saveAs($banner_path.'/'.$fileName)) {
						if($setting->banner_validation == 0 && $setting->banner_resize == 1)
							self::resizeBanner($banner_path.'/'.$fileName, unserialize($this->category->banner_size));
						self::model()->updateByPk($this->banner_id, array('banner_filename'=>$fileName));
					}
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
		
		if($this->banner_filename != '' && file_exists($banner_path.'/'.$this->banner_filename))
			rename($banner_path.'/'.$this->banner_filename, 'public/banner/verwijderen/'.$this->banner_id.'_'.$this->banner_filename);
	}

}