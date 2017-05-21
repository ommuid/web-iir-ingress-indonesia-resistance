<?php
/**
 * DaopAnotherUser
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
 * This is the model class for table "ommu_daop_another_user".
 *
 * The followings are the available columns in table 'ommu_daop_another_user':
 * @property string $id
 * @property string $another_id
 * @property string $user_id
 * @property string $creation_date
 *
 * The followings are the available model relations:
 * @property OmmuDaopAnothers $another
 */
class DaopAnotherUser extends CActiveRecord
{
	public $defaultColumns = array();
	public $another_input;
	
	// Variable Search
	public $provinceId_search;
	public $cityId_search;
	public $another_search;
	public $user_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DaopAnotherUser the static model class
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
		return 'ommu_daop_another_user';
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
				another_input', 'required'),
			array('another_id, user_id', 'required'),
			array('another_id, user_id', 'length', 'max'=>11),
			array('another_id, user_id,
				provinceId_search, cityId_search', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, another_id, user_id, creation_date,
				provinceId_search, cityId_search, another_search, user_search', 'safe', 'on'=>'search'),
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
			'another_relation' => array(self::BELONGS_TO, 'DaopAnothers', 'another_id'),
			'user_relation' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'another_id' => 'Another',
			'user_id' => 'User',
			'creation_date' => 'Creation Date',
			'provinceId_search' => 'Province',
			'cityId_search' => 'City',
			'another_input' => 'Another',
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

		$criteria->compare('t.id',$this->id,true);
		if(isset($_GET['another'])) {
			$criteria->compare('t.another_id',$_GET['another']);
		} else {
			$criteria->compare('t.another_id',$this->another_id);
		}
		if(isset($_GET['user'])) {
			$criteria->compare('t.user_id',$_GET['user']);
		} else {
			$criteria->compare('t.user_id',$this->user_id);
		}
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		
		// Custom Search
		$criteria->with = array(
			'another_relation' => array(
				'alias'=>'another_relation',
				'select'=>'another_name, province_id, city_id',
			),
			'user_relation' => array(
				'alias'=>'user_relation',
				'select'=>'displayname',
			),
		);
		$criteria->compare('another_relation.province_id',strtolower($this->provinceId_search), true);
		$criteria->compare('another_relation.city_id',strtolower($this->cityId_search), true);
		$criteria->compare('another_relation.another_name',strtolower($this->another_search), true);
		$criteria->compare('user_relation.displayname',strtolower($this->user_search), true);

		if(!isset($_GET['DaopAnotherUser_sort']))
			$criteria->order = 'id DESC';

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
			//$this->defaultColumns[] = 'id';
			$this->defaultColumns[] = 'another_id';
			$this->defaultColumns[] = 'user_id';
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
				'name' => 'another_search',
				'value' => '$data->another_relation->another_name',
			);
			$this->defaultColumns[] = array(
				'name' => 'user_search',
				'value' => '$data->user_relation->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Utility::dateFormat($data->creation_date)',
				'htmlOptions' => array(
					//'class' => 'center',
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
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			if($this->isNewRecord) {
				if($this->another_id == 0) {
					$another = DaopAnothers::model()->find(array(
						'select' => 'another_id, another_name',
						'condition' => 'another_name = :another',
						'params' => array(
							':another' => $this->another_input,
						),
					));
					if($another != null) {
						$this->another_id = $another->another_id;
					} else {
						$data = new DaopAnothers;
						$data->another_name = $this->another_input;
						if($data->save()) {
							$this->another_id = $data->another_id;
						}
					}					
				}
			}
		}
		return true;
	}

}