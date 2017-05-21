<?php
/**
 * DaopUsers
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
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
 * This is the model class for table "ommu_daop_users".
 *
 * The followings are the available columns in table 'ommu_daop_users':
 * @property string $daop_id
 * @property string $user_id
 * @property integer $country_id
 * @property integer $province_id
 * @property string $city_id
 * @property string $creation_date
 */
class DaopUsers extends CActiveRecord
{
	public $defaultColumns = array();
	public $city_input;
	
	// Variable Search
	public $province_search;
	public $city_search;
	public $user_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DaopUsers the static model class
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
		return 'ommu_daop_users';
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
				city_input', 'required', 'on'=>'form'),
			array('
				user_id, city_id', 'required', 'on'=>'cityadd'),
			array('country_id, province_id', 'numerical', 'integerOnly'=>true),
			array('user_id, city_id', 'length', 'max'=>11),
			array('user_id, country_id, province_id, city_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('daop_id, user_id, country_id, province_id, city_id, creation_date,
				province_search, city_search, user_search', 'safe', 'on'=>'search'),
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
			'city_relation' => array(self::BELONGS_TO, 'OmmuZoneCity', 'city_id'),
			'province_relation' => array(self::BELONGS_TO, 'OmmuZoneProvince', 'province_id'),
			'country_relation' => array(self::BELONGS_TO, 'OmmuZoneCountry', 'country_id'),
			'user_relation' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'daop_id' => 'Daop',
			'user_id' => 'User',
			'country_id' => 'Country',
			'province_id' => 'Province',
			'city_id' => 'City',
			'creation_date' => 'Creation Date',
			'city_input' => 'City',
			'province_search' => 'Province',
			'city_search' => 'City',
			'user_search' => 'User',
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

		$criteria->compare('t.daop_id',$this->daop_id,true);
		if(isset($_GET['user'])) {
			$criteria->compare('t.user_id',$_GET['user']);
		} else {
			$criteria->compare('t.user_id',$this->user_id);
		}
		if(isset($_GET['country'])) {
			$criteria->compare('t.country_id',$_GET['province']);
		} else {
			$criteria->compare('t.country_id',$this->country_id);
		}
		if(isset($_GET['province'])) {
			$criteria->compare('t.province_id',$_GET['province']);
		} else {
			$criteria->compare('t.province_id',$this->province_id);
		}
		if(isset($_GET['city'])) {
			$criteria->compare('t.city_id',$_GET['city']);
		} else {
			$criteria->compare('t.city_id',$this->city_id);
		}
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		
		// Custom Search
		$criteria->with = array(
			'province_relation' => array(
				'alias'=>'province_relation',
				'select'=>'province',
			),
			'city_relation' => array(
				'alias'=>'city_relation',
				'select'=>'city',
			),
			'user_relation' => array(
				'alias'=>'user_relation',
				'select'=>'displayname',
			),
		);
		$criteria->compare('province_relation.province',strtolower($this->province_search), true);
		$criteria->compare('city_relation.city',strtolower($this->city_search), true);
		$criteria->compare('user_relation.displayname',strtolower($this->user_search), true);

		if(!isset($_GET['DaopUsers_sort']))
			$criteria->order = 'daop_id DESC';

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
			//$this->defaultColumns[] = 'daop_id';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'country_id';
			$this->defaultColumns[] = 'province_id';
			$this->defaultColumns[] = 'city_id';
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
			$this->defaultColumns[] = array(
				'name' => 'user_search',
				'value' => '$data->user_relation->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'city_search',
				'value' => '$data->city_relation->city',
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
	 * before validate attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			if($this->isNewRecord) {
				$this->user_id = Yii::app()->user->id;
			}
		}
		return true;
	}

}