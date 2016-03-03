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
 * This is the model class for table "ommu_core_zone_country".
 *
 * The followings are the available columns in table 'ommu_core_zone_country':
 * @property integer $country_id
 * @property string $country
 * @property string $code
 *
 * The followings are the available model relations:
 * @property OmmuCoreZoneProvince[] $ommuCoreZoneProvinces
 */
class OmmuZoneCountry extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OmmuZoneCountry the static model class
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
		return 'ommu_core_zone_country';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country, code', 'required'),
			array('country', 'length', 'max'=>64),
			array('code', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('country_id, country, code', 'safe', 'on'=>'search'),
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
			'country_id' => Phrase::trans(422,0),
			'country' => Phrase::trans(422,0),
			'code' => Phrase::trans(423,0),
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

		$criteria->compare('t.country_id',$this->country_id);
		$criteria->compare('t.country',strtolower($this->country),true);
		$criteria->compare('t.code',strtolower($this->code),true);

		if(!isset($_GET['OmmuZoneCountry_sort']))
			$criteria->order = 'country_id DESC';

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
			//$this->defaultColumns[] = 'country_id';
			$this->defaultColumns[] = 'country';
			$this->defaultColumns[] = 'code';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			$this->defaultColumns[] = 'country_id';
			$this->defaultColumns[] = 'country';
			$this->defaultColumns[] = 'code';

		}
		parent::afterConstruct();
	}

	/**
	 * Get country
	 */
	public static function getCountry() {
		$model = self::model()->findAll();

		$items = array();
		if($model != null) {
			foreach($model as $key => $val) {
				$items[$val->country_id] = $val->country;
			}
			return $items;
		} else {
			return false;
		}
	}

	/**
	 * Get country information
	 */
	public static function getInfo($id, $column)
	{
		$model = self::model()->findByPk($id,array(
			'select' => $column
		));
		return $model->$column;
	}

}