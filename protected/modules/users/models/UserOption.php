<?php
/**
 * UserOption
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Users
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
 * This is the model class for table "ommu_user_option".
 *
 * The followings are the available columns in table 'ommu_user_option':
 * @property string $option_id
 * @property integer $ommu_status
 * @property integer $invite_limit
 * @property integer $invite_success
 * @property string $signup_from
 */
class UserOption extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserOption the static model class
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
		return 'ommu_user_option';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('option_id', 'required'),
			array('ommu_status, invite_limit, invite_success', 'numerical', 'integerOnly'=>true),
			array('option_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('option_id, ommu_status, invite_limit, invite_success, signup_from', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'option_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'option_id' => Yii::t('attribute', 'Option'),
			'ommu_status' =>  Yii::t('attribute', 'Ommu Status'),
			'invite_limit' => Yii::t('attribute', 'Invite Limit'),
			'invite_success' => Yii::t('attribute', 'Invite Success'),
			'signup_from' => Yii::t('attribute', 'Signup From'),
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
		
		$criteria->compare('t.option_id',$this->option_id);
		$criteria->compare('t.ommu_status',$this->ommu_status);
		$criteria->compare('t.invite_limit',$this->invite_limit);
		$criteria->compare('t.invite_success',$this->invite_success);
		$criteria->compare('t.signup_from',$this->signup_from);

		if(!isset($_GET['UserOption_sort']))
			$criteria->order = 't.option_id DESC';

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
		} else {
			$this->defaultColumns[] = 'option_id';
			$this->defaultColumns[] = 'ommu_status';
			$this->defaultColumns[] = 'invite_limit';
			$this->defaultColumns[] = 'invite_success';
			$this->defaultColumns[] = 'signup_from';
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
			$this->defaultColumns[] = 'option_id';
			$this->defaultColumns[] = 'ommu_status';
			$this->defaultColumns[] = 'invite_limit';
			$this->defaultColumns[] = 'invite_success';
			$this->defaultColumns[] = 'signup_from';
		}
		parent::afterConstruct();
	}

}