<?php
/**
 * DaopAnothers
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
 * This is the model class for table "ommu_daop_anothers".
 *
 * The followings are the available columns in table 'ommu_daop_anothers':
 * @property string $another_id
 * @property integer $status
 * @property string $another_name
 * @property string $another_desc
 * @property string $another_cover
 * @property string $another_photo
 * @property integer $country_id
 * @property integer $province_id
 * @property string $city_id
 * @property integer $users
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuDaopAnotherHistory[] $ommuDaopAnotherHistories
 * @property OmmuDaopAnotherUser[] $ommuDaopAnotherUsers
 */
class DaopAnothers extends CActiveRecord
{
	public $defaultColumns = array();
	public $city_input;
	
	// Variable Search
	public $province_search;
	public $city_search;
	public $creation_search;
	public $modified_search;
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DaopAnothers the static model class
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
		return 'ommu_daop_anothers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('another_name,
				city_input', 'required', 'on'=>'form'),
			array('status, country_id, province_id, users', 'numerical', 'integerOnly'=>true),
			array('another_name, another_cover, another_photo', 'length', 'max'=>64),
			array('city_id, creation_id, modified_id', 'length', 'max'=>11),
			array('status, another_desc, another_cover, another_photo, city_id,
				creation_id, modified_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('another_id, status, another_name, another_desc, another_cover, another_photo, country_id, province_id, city_id, users, creation_date, creation_id, modified_date, modified_id,
				province_search, city_search, creation_search, modified_search', 'safe', 'on'=>'search'),
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
			'creation_relation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified_relation' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			
			'ommuDaopAnotherHistories' => array(self::HAS_MANY, 'OmmuDaopAnotherHistory', 'another_id'),
			'ommuDaopAnotherUsers' => array(self::HAS_MANY, 'OmmuDaopAnotherUser', 'another_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'another_id' => 'Another',
			'status' => 'Status',
			'another_name' => 'Another Name',
			'another_desc' => 'Another Desc',
			'another_cover' => 'Another Cover',
			'another_photo' => 'Another Photo',
			'country_id' => 'Country',
			'province_id' => 'Province',
			'city_id' => 'City',
			'users' => 'Users',
			'creation_date' => 'Creation Date',
			'creation_id' => 'Creation',
			'modified_date' => 'Modified Date',
			'modified_id' => 'Modified',
			'city_input' => 'City',
			'province_search' => 'Province',
			'city_search' => 'City',
			'creation_search' => 'Creation',
			'modified_search' => 'Modified',
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

		$criteria->compare('t.another_id',$this->another_id,true);
		$criteria->compare('t.status',$this->status);
		$criteria->compare('t.another_name',$this->another_name,true);
		$criteria->compare('t.another_desc',$this->another_desc,true);
		$criteria->compare('t.another_cover',$this->another_cover,true);
		$criteria->compare('t.another_photo',$this->another_photo,true);
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
		$criteria->compare('t.users',$this->users);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		if(isset($_GET['creation'])) {
			$criteria->compare('t.creation_id',$_GET['creation']);
		} else {
			$criteria->compare('t.creation_id',$this->creation_id);
		}
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		if(isset($_GET['modified'])) {
			$criteria->compare('t.modified_id',$_GET['modified']);
		} else {
			$criteria->compare('t.modified_id',$this->modified_id);
		}
		
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
			'creation_relation' => array(
				'alias'=>'creation_relation',
				'select'=>'displayname',
			),
			'modified_relation' => array(
				'alias'=>'modified_relation',
				'select'=>'displayname',
			),
		);
		$criteria->compare('province_relation.province',strtolower($this->province_search), true);
		$criteria->compare('city_relation.city',strtolower($this->city_search), true);
		$criteria->compare('creation_relation.displayname',strtolower($this->creation_search), true);
		$criteria->compare('modified_relation.displayname',strtolower($this->modified_search), true);

		if(!isset($_GET['DaopAnothers_sort']))
			$criteria->order = 'another_id DESC';

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
			//$this->defaultColumns[] = 'another_id';
			$this->defaultColumns[] = 'status';
			$this->defaultColumns[] = 'another_name';
			$this->defaultColumns[] = 'another_desc';
			$this->defaultColumns[] = 'another_cover';
			$this->defaultColumns[] = 'another_photo';
			$this->defaultColumns[] = 'country_id';
			$this->defaultColumns[] = 'province_id';
			$this->defaultColumns[] = 'city_id';
			$this->defaultColumns[] = 'users';
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
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			$this->defaultColumns[] = 'another_name';
			$this->defaultColumns[] = array(
				'name' => 'city_search',
				'value' => '$data->city_relation->city',
			);
			/*
			$this->defaultColumns[] = array(
				'name' => 'province_search',
				'value' => '$data->province_relation->province',
			);
			*/
			$this->defaultColumns[] = 'users';
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
			$this->defaultColumns[] = array(
				'name' => 'creation_search',
				'value' => '$data->creation_relation->displayname',
			);
			/*
			$this->defaultColumns[] = array(
				'name' => 'modified_date',
				'value' => 'Utility::dateFormat($data->modified_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'modified_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'modified_date_filter',
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
				'name' => 'modified_search',
				'value' => '$data->modified_relation->displayname',
			);
			*/
			$this->defaultColumns[] = array(
				'name' => 'status',
				'value' => '$data->status',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					0=>'Request',
					1=>'Approve',
					2=>'Blocked',
				),
				'type' => 'raw',
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
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			if($this->isNewRecord) {
				$this->creation_id = Yii::app()->user->id;
			} else {
				$this->modified_id = Yii::app()->user->id;
			}
		}
		return true;	
	}

}