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
 * @property integer $media_limit
 * @property integer $media_resize
 * @property string $media_resize_size
 * @property string $media_large_width
 * @property string $media_large_height
 * @property string $media_medium_width
 * @property string $media_medium_height
 * @property string $media_small_width
 * @property string $media_small_height
 */
class ArticleSetting extends CActiveRecord
{
	public $defaultColumns = array();
	public $media_resize_width;
	public $media_resize_height;

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
			array('license, permission, meta_keyword, meta_description, type_active, headline, media_limit, media_resize, media_large_width, media_large_height, media_medium_width, media_medium_height, media_small_width, media_small_height', 'required'),
			array('permission, headline, media_limit, media_resize', 'numerical', 'integerOnly'=>true),
			//array('type_active', 'length', 'max'=>64),
			array('license', 'length', 'max'=>32),
			array('media_large_width, media_large_height,
				media_resize_width, media_resize_height', 'length', 'max'=>4),
			array('media_medium_width, media_medium_height, media_small_width, media_small_height', 'length', 'max'=>3),
			array('media_resize_size,
				media_resize_width, media_resize_height', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, license, permission, meta_keyword, meta_description, type_active, headline, media_limit, media_resize, media_large_width, media_large_height, media_medium_width, media_medium_height, media_small_width, media_small_height', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'license' => Phrase::trans(26003,1),
			'permission' => Phrase::trans(26006,1),
			'meta_keyword' => Phrase::trans(26010,1),
			'meta_description' => Phrase::trans(26011,1),
			'type_active' => Phrase::trans(26104,1),
			'headline' => Phrase::trans(26058,1),
			'media_limit' => Phrase::trans(26012,1),
			'media_resize' => Phrase::trans(26087,1),
			'media_resize_size' => Phrase::trans(26109,1),
			'media_large_width' => Phrase::trans(26098,1),
			'media_large_height' => Phrase::trans(26099,1),
			'media_medium_width' => Phrase::trans(26100,1),
			'media_medium_height' => Phrase::trans(26101,1),
			'media_small_width' => Phrase::trans(26102,1),
			'media_small_height' => Phrase::trans(26103,1),
			'media_resize_width' => Phrase::trans(261010,1),
			'media_resize_height' => Phrase::trans(26111,1),
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

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.license',$this->license,true);
		$criteria->compare('t.permission',$this->permission);
		$criteria->compare('t.meta_keyword',$this->meta_keyword,true);
		$criteria->compare('t.meta_description',$this->meta_description,true);
		$criteria->compare('t.type_active',$this->type_active);
		$criteria->compare('t.headline',$this->headline);
		$criteria->compare('t.media_limit',$this->media_limit);
		$criteria->compare('t.media_resize',$this->media_resize);
		$criteria->compare('t.media_resize_size',$this->media_resize_size);
		$criteria->compare('t.media_large_width',$this->media_large_width);
		$criteria->compare('t.media_large_height',$this->media_large_height);
		$criteria->compare('t.media_medium_width',$this->media_medium_width);
		$criteria->compare('t.media_medium_height',$this->media_medium_height);
		$criteria->compare('t.media_small_width',$this->media_small_width);
		$criteria->compare('t.media_small_height',$this->media_small_height);

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
			$this->defaultColumns[] = 'media_limit';
			$this->defaultColumns[] = 'media_resize';
			$this->defaultColumns[] = 'media_resize_size';
			$this->defaultColumns[] = 'media_large_width';
			$this->defaultColumns[] = 'media_large_height';
			$this->defaultColumns[] = 'media_medium_width';
			$this->defaultColumns[] = 'media_medium_height';
			$this->defaultColumns[] = 'media_small_width';
			$this->defaultColumns[] = 'media_small_height';
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
			$this->defaultColumns[] = 'media_limit';
			$this->defaultColumns[] = 'media_resize';
			$this->defaultColumns[] = 'media_resize_size';
			$this->defaultColumns[] = 'media_large_width';
			$this->defaultColumns[] = 'media_large_height';
			$this->defaultColumns[] = 'media_medium_width';
			$this->defaultColumns[] = 'media_medium_height';
			$this->defaultColumns[] = 'media_small_width';
			$this->defaultColumns[] = 'media_small_height';
		}
		parent::afterConstruct();
	}

	/**
	 * User get information
	 */
	public static function getInfo($column, $type=null)
	{
		if($type != null && $type == 'many') {
			$model = self::model()->findByPk(1,array(
				'select' => $column
			));
			return $model;
		
		} else {
			$model = self::model()->findByPk(1,array(
				'select' => $column
			));
			return $model->$column;
		}
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->media_resize == 1 && ($this->media_resize_width == '' || $this->media_resize_height == '')) {
				$this->addError('media_resize_size', Phrase::trans(26112,1));
			}
			if($this->media_large_width == '' || $this->media_large_height == '') {
				$this->addError('media_large_width', Phrase::trans(26093,1));
			}
			if($this->media_medium_width == '' || $this->media_medium_height == '') {
				$this->addError('media_medium_width', Phrase::trans(26094,1));
			}
			if($this->media_small_width == '' || $this->media_small_height == '') {
				$this->addError('media_small_width', Phrase::trans(26095,1));
			}
			
			// Article type is active
			$this->type_active = implode(',', $this->type_active);
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			if($this->media_resize == 1) {
				$this->media_resize_size = $this->media_resize_width.','.$this->media_resize_height;
			}
		}
		return true;
	}

}