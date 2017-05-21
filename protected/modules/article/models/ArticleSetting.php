<?php
/**
 * ArticleSetting
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/mod-article
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
 * This is the model class for table "ommu_article_setting".
 *
 * The followings are the available columns in table 'ommu_article_setting':
 * @property integer $id
 * @property string $license
 * @property integer $permission
 * @property string $meta_keyword
 * @property string $meta_description
 * @property string $type_active
 * @property integer $headline
 * @property integer $headline_limit
 * @property string $headline_category
 * @property integer $media_limit
 * @property integer $media_resize
 * @property string $media_resize_size
 * @property string $media_view_size
 * @property string $media_file_type
 * @property string $upload_file_type
 * @property string $modified_date
 * @property string $modified_id
 */
class ArticleSetting extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ArticleSetting the static model class
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
		return 'ommu_article_setting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('license, permission, meta_keyword, meta_description, type_active, headline, headline_limit, media_limit, media_resize, media_file_type, upload_file_type', 'required'),
			array('permission, headline, headline_limit, media_limit, media_resize, modified_id', 'numerical', 'integerOnly'=>true),
			array('license', 'length', 'max'=>32),
			array('headline_limit', 'length', 'max'=>3),
			array('headline_category, media_resize_size, media_view_size, media_file_type, upload_file_type', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, license, permission, meta_keyword, meta_description, type_active, headline, headline_limit, headline_category, media_limit, media_resize, media_resize_size, media_view_size, media_file_type, upload_file_type, modified_date, modified_id,
				modified_search', 'safe', 'on'=>'search'),
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
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('attribute', 'ID'),
			'license' => Yii::t('attribute', 'License Key'),
			'permission' => Yii::t('attribute', 'Public Permission Defaults'),
			'meta_keyword' => Yii::t('attribute', 'Meta Keyword'),
			'meta_description' => Yii::t('attribute', 'Meta Description'),
			'type_active' => Yii::t('attribute', 'Type Active'),
			'headline' => Yii::t('attribute', 'Headline'),
			'headline_limit' => Yii::t('attribute', 'Headline Limit'),
			'headline_category' => Yii::t('attribute', 'Headline Category'),
			'media_limit' => Yii::t('attribute', 'Media Limit'),
			'media_resize' => Yii::t('attribute', 'Media Resize'),
			'media_resize_size' => Yii::t('attribute', 'Media Resize Size'),
			'media_view_size' => Yii::t('attribute', 'Media View Size'),
			'media_file_type' => Yii::t('attribute', 'Media File Type'),
			'upload_file_type' => Yii::t('attribute', 'Upload File Type'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'modified_search' => Yii::t('attribute', 'Modified'),
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
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname'
			),
		);

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.license',$this->license,true);
		$criteria->compare('t.permission',$this->permission);
		$criteria->compare('t.meta_keyword',$this->meta_keyword,true);
		$criteria->compare('t.meta_description',$this->meta_description,true);
		$criteria->compare('t.type_active',$this->type_active);
		$criteria->compare('t.headline',$this->headline);
		$criteria->compare('t.headline_limit',$this->headline_limit);
		$criteria->compare('t.headline_category',$this->headline_category,true);
		$criteria->compare('t.media_limit',$this->media_limit);
		$criteria->compare('t.media_resize',$this->media_resize);
		$criteria->compare('t.media_resize_size',$this->media_resize_size,true);
		$criteria->compare('t.media_view_size',$this->media_view_size,true);
		$criteria->compare('t.media_file_type',$this->media_file_type,true);
		$criteria->compare('t.upload_file_type',$this->upload_file_type,true);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id',$this->modified_id);
		
		$criteria->compare('modified.displayname',strtolower($this->modified_search), true);

		if(!isset($_GET['ArticleSetting_sort']))
			$criteria->order = 't.id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
			//$this->defaultColumns[] = 'id';
			$this->defaultColumns[] = 'license';
			$this->defaultColumns[] = 'permission';
			$this->defaultColumns[] = 'meta_keyword';
			$this->defaultColumns[] = 'meta_description';
			$this->defaultColumns[] = 'type_active';
			$this->defaultColumns[] = 'headline';
			$this->defaultColumns[] = 'headline_limit';
			$this->defaultColumns[] = 'headline_category';
			$this->defaultColumns[] = 'media_limit';
			$this->defaultColumns[] = 'media_resize';
			$this->defaultColumns[] = 'media_resize_size';
			$this->defaultColumns[] = 'media_view_size';
			$this->defaultColumns[] = 'media_file_type';
			$this->defaultColumns[] = 'upload_file_type';
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
			$this->defaultColumns[] = 'license';
			$this->defaultColumns[] = 'permission';
			$this->defaultColumns[] = 'meta_keyword';
			$this->defaultColumns[] = 'meta_description';
			$this->defaultColumns[] = 'type_active';
			$this->defaultColumns[] = 'headline';
			$this->defaultColumns[] = 'headline_limit';
			$this->defaultColumns[] = 'headline_category';
			$this->defaultColumns[] = 'media_limit';
			$this->defaultColumns[] = 'media_resize';
			$this->defaultColumns[] = 'media_resize_size';
			$this->defaultColumns[] = 'media_view_size';
			$this->defaultColumns[] = 'media_file_type';
			$this->defaultColumns[] = 'upload_file_type';
			$this->defaultColumns[] = 'modified_date';
			$this->defaultColumns[] = array(
				'name' => 'modified_search',
				'value' => '$data->modified->displayname',
			);
		}
		parent::afterConstruct();
	}

	/**
	 * User get information
	 */
	public static function getInfo($column=null)
	{
		if($column != null) {
			$model = self::model()->findByPk(1,array(
				'select' => $column
			));
			return $model->$column;
		
		} else {
			$model = self::model()->findByPk(1);
			return $model;
		}
	}

	/**
	 * User get information
	 */
	public static function getHeadlineCategory()
	{
		$setting = self::model()->findByPk(1, array(
			'select' => 'headline_category',
		));
		
		$headline_category = unserialize($setting->headline_category);
		if(empty($headline_category))
			$headline_category = array();
		
		return $headline_category;		
	}

	/**
	 * get Module License
	 */
	public static function getLicense($source='1234567890', $length=16, $char=4)
	{
		$mod = $length%$char;
		if($mod == 0)
			$sep = ($length/$char);
		else
			$sep = (int)($length/$char)+1;
		
		$sourceLength = strlen($source);
		$random = '';
		for ($i = 0; $i < $length; $i++)
			$random .= $source[rand(0, $sourceLength - 1)];
		
		$license = '';
		for ($i = 0; $i < $sep; $i++) {
			if($i != $sep-1)
				$license .= substr($random,($i*$char),$char).'-';
			else
				$license .= substr($random,($i*$char),$char);
		}

		return $license;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->headline == 1) {
				if($this->headline_limit != '' && $this->headline_limit <= 0)
					$this->addError('headline_limit', Yii::t('phrase', 'Headline Limit lebih besar dari 0'));
				if($this->headline_category == '')
					$this->addError('headline_category', Yii::t('phrase', 'Headline Category cannot be blank.'));
			}
			
			if($this->media_limit != '' && $this->media_limit <= 0)
				$this->addError('media_limit', Yii::t('phrase', 'Photo Limit lebih besar dari 0'));
			
			if($this->media_resize == 1 && ($this->media_resize_size['width'] == '' || $this->media_resize_size['height'] == ''))
				$this->addError('media_resize_size', Yii::t('phrase', 'Media Resize cannot be blank.'));
			
			if($this->media_view_size['large']['width'] == '' || $this->media_view_size['large']['height'] == '')
				$this->addError('media_view_size[large]', Yii::t('phrase', 'Large Size cannot be blank.'));
			
			if($this->media_view_size['medium']['width'] == '' || $this->media_view_size['medium']['height'] == '')
				$this->addError('media_view_size[medium]', Yii::t('phrase', 'Medium Size cannot be blank.'));
			
			if($this->media_view_size['small']['width'] == '' || $this->media_view_size['small']['height'] == '')
				$this->addError('media_view_size[small]', Yii::t('phrase', 'Small Size cannot be blank.'));
			
			// Article type is active
			
			$this->modified_id = Yii::app()->user->id;
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$this->type_active = serialize($this->type_active);
			$this->headline_category = serialize($this->headline_category);
			$this->media_resize_size = serialize($this->media_resize_size);
			$this->media_view_size = serialize($this->media_view_size);
			$this->media_file_type = serialize(Utility::formatFileType($this->media_file_type));
			$this->upload_file_type = serialize(Utility::formatFileType($this->upload_file_type));
		}
		return true;
	}

}