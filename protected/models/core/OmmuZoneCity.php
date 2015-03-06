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
 * This is the model class for table "ommu_core_zone_city".
 *
 * The followings are the available columns in table 'ommu_core_zone_city':
 * @property string $city_id
 * @property integer $province_id
 * @property string $city
 *
 * The followings are the available model relations:
 * @property OmmuCoreZoneProvince $province
 */
class OmmuZoneCity extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OmmuZoneCity the static model class
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
		return 'ommu_core_zone_city';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('province_id, city', 'required'),
			array('province_id', 'numerical', 'integerOnly'=>true),
			array('city', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('city_id, province_id, city', 'safe', 'on'=>'search'),
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
			'province' => array(self::BELONGS_TO, 'OmmuZoneProvince', 'province_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'city_id' => Phrase::trans(424,0),
			'province_id' => Phrase::trans(421,0),
			'city' => Phrase::trans(424,0),
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

		$criteria->compare('t.city_id',$this->city_id);
		$criteria->compare('t.province_id',$this->province_id);
		$criteria->compare('t.city',strtolower($this->city),true);

		if(!isset($_GET['OmmuZoneCity_sort']))
			$criteria->order = 'city_id DESC';

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
			//$this->defaultColumns[] = 'city_id';
			$this->defaultColumns[] = 'province_id';
			$this->defaultColumns[] = 'city';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			$this->defaultColumns[] = 'city_id';
			$this->defaultColumns[] = 'province_id';
			$this->defaultColumns[] = 'city';

		}
		parent::afterConstruct();
	}

	/**
	 * Get city
	 */
	public static function getCity($province=null) {
		if($province == null || $province == '') {
			$model = self::model()->findAll();
		} else {
			$model = self::model()->findAll(array(
				//'select' => 'publish, name',
				'condition' => 'province_id = :province',
				'params' => array(
					':province' => $province,
				),
			));
		}

		$items = array();
		if($model != null) {
			foreach($model as $key => $val) {
				$items[$val->city_id] = $val->city;
			}
			return $items;
		} else {
			return false;
		}
	}

	/**
	 * Get city information
	 */
	public static function getInfo($id, $column)
	{
		$model = self::model()->findByPk($id,array(
			'select' => $column
		));
		return $model->$column;
	}

}