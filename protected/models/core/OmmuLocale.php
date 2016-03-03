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
 * This is the model class for table "ommu_core_locale".
 *
 * The followings are the available columns in table 'ommu_core_locale':
 * @property integer $locale_id
 * @property integer $defaults
 * @property string $locale
 * @property string $title
 */
class OmmuLocale extends CActiveRecord
{
	public $defaultColumns = array();
	public $default_locale;
	public $timezone;
	public $dateformat;
	public $timeformat;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OmmuLocale the static model class
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
		return 'ommu_core_locale';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('
				default_locale, timezone, dateformat, timeformat', 'required'),
			array('defaults,
				default_locale, timezone', 'numerical', 'integerOnly'=>true),
			array('locale', 'length', 'max'=>16),
			array('title', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('locale_id, defaults, locale, title', 'safe', 'on'=>'search'),
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
			'locale_id' => Phrase::trans(427,0),
			'defaults' => Phrase::trans(156,0),
			'locale' => Phrase::trans(427,0),
			'title' => Phrase::trans(190,0),
			'default_locale' => Phrase::trans(245,0),
			'timezone' => Phrase::trans(244,0),
			'dateformat' => Phrase::trans(512,0),
			'timeformat' => Phrase::trans(513,0),
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

		$criteria->compare('t.locale_id',$this->locale_id);
		$criteria->compare('t.defaults',$this->defaults);
		$criteria->compare('t.locale',strtolower($this->locale),true);
		$criteria->compare('t.title',strtolower($this->title),true);

		if(!isset($_GET['OmmuLocale_sort']))
			$criteria->order = 'locale_id DESC';

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
			//$this->defaultColumns[] = 'locale_id';
			$this->defaultColumns[] = 'defaults';
			$this->defaultColumns[] = 'locale';
			$this->defaultColumns[] = 'title';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			$this->defaultColumns[] = 'locale_id';
			$this->defaultColumns[] = 'defaults';
			$this->defaultColumns[] = 'locale';
			$this->defaultColumns[] = 'title';
		}
		parent::afterConstruct();
	}

	/**
	 * Get Default
	 */
	public static function getDefault(){
		$model = self::model()->findByAttributes(array('defaults' => 1));
		return $model->locale_id;
	}

	/**
	 * Get Locale
	 */
	public static function getLocale() {
		$model = self::model()->findAll();
		$items = array();
		if($model != null) {
			foreach($model as $key => $val) {
				$items[$val->locale_id] = $val->title;
			}
			return $items;
		}else {
			return false;
		}
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->dateformat == '' || $this->timeformat == '') {
				$this->addError('dateformat', Phrase::trans(514,0));
			}
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			if(!$this->isNewRecord) {
				if($this->defaults != 1) {
					self::model()->updateAll(array(
						'defaults' => 0,	
					));
					$this->defaults = 1;
				}
			}
		}
		return true;
	}

}