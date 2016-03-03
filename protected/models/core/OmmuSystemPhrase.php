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
 * This is the model class for table "ommu_core_system_phrase".
 *
 * The followings are the available columns in table 'ommu_core_system_phrase':
 * @property string $phrase_id
 * @property string $location
 * @property string $en
 */
class OmmuSystemPhrase extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OmmuSystemPhrase the static model class
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
		return 'ommu_core_system_phrase';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('en', 'required'),
			array('location', 'length', 'max'=>32),
			array('location, id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('phrase_id, location, en', 'safe', 'on'=>'search'),
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
			'phrase_id' => Phrase::trans(176,0),
			'location' => Phrase::trans(359,0),
			'en' => 'English',
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
		$controller = strtolower(Yii::app()->controller->id);

		$criteria=new CDbCriteria;

		if($controller == 'translate') {
			$criteria->condition = 'phrase_id > :id';
			$criteria->params = array(
				':id'=>1000, 
			);
		} else {
			$criteria->compare('t.phrase_id',$this->phrase_id);
		}
		$criteria->compare('t.location',strtolower($this->location),true);
		$criteria->compare('t.en',strtolower($this->en),true);
		
		if(!isset($_GET['OmmuSystemPhrase_sort']))
			$criteria->order = 'phrase_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>40,
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
			//$this->defaultColumns[] = 'phrase_id';
			$this->defaultColumns[] = 'location';
			$this->defaultColumns[] = 'en';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			$this->defaultColumns[] = 'phrase_id';
			$this->defaultColumns[] = 'en';
			$this->defaultColumns[] = 'id';
			$this->defaultColumns[] = 'location';
		}
		parent::afterConstruct();
	}

	/**
	 * get public phrase
	 */
	public static function getPublicPhrase($select=null)
	{
		$criteria=new CDbCriteria;
		$criteria->condition = 'phrase_id > :first AND phrase_id < :last';
		$criteria->params = array(
			':first'=>1000, 
			':last'=>1500,
		);
		if($select != null)
			$criteria->select = $select;
		$model = self::model()->findAll($criteria);
		
		return $model;
	}

	/**
	 * get public phrase
	 */
	public static function getDynamicPhrase($select=null)
	{
		$criteria=new CDbCriteria;
		$criteria->condition = 'phrase_id > :id';
		$criteria->params = array(
			':id'=>1500, 
		);
		if($select != null)
			$criteria->select = $select;
		$model = self::model()->findAll($criteria);
		
		return $model;
	}

	/**
	 * get admin phrase
	 */
	public static function getAdminPhrase($select=null)
	{
		$criteria=new CDbCriteria;
		$criteria->condition = 'phrase_id < :id';
		$criteria->params = array(
			':id'=>1000, 
		);
		if($select != null)
			$criteria->select = $select;
		$model = self::model()->findAll($criteria);
		
		return $model;
	}

}