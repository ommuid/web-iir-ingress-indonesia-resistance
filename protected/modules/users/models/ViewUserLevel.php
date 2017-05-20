<?php
/**
 * ViewUserLevel
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
 * This is the model class for table "_view_user_level".
 *
 * The followings are the available columns in table '_view_user_level':
 * @property integer $level_id
 * @property string $users
 * @property string $user_pending
 * @property string $user_noverified
 * @property string $user_blocked
 * @property string $user_all
 */
class ViewUserLevel extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewUserLevel the static model class
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
		return '_view_user_level';
	}

	/**
	 * @return string the primarykey column
	 */
	public function primaryKey()
	{
		return 'level_id';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('level_id', 'numerical', 'integerOnly'=>true),
			array('users, user_pending, user_noverified, user_blocked, user_all', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('level_id, users, user_pending, user_noverified, user_blocked, user_all', 'safe', 'on'=>'search'),
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
			'level_id' => Yii::t('attribute', 'Level'),
			'users' => Yii::t('attribute', 'Users'),
			'user_pending' => Yii::t('attribute', 'Pending'),
			'user_noverified' => Yii::t('attribute', 'No Verified'),
			'user_blocked' => Yii::t('attribute', 'Blocked'),
			'user_all' => Yii::t('attribute', 'User All'),
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

		$criteria->compare('t.level_id',$this->level_id);
		$criteria->compare('t.users',$this->users);
		$criteria->compare('t.user_pending',$this->user_pending);
		$criteria->compare('t.user_noverified',$this->user_noverified);
		$criteria->compare('t.user_blocked',$this->user_blocked);
		$criteria->compare('t.user_all',$this->user_all);

		if(!isset($_GET['ViewUserLevel_sort']))
			$criteria->order = 't.level_id DESC';

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
			$this->defaultColumns[] = 'level_id';
			$this->defaultColumns[] = 'users';
			$this->defaultColumns[] = 'user_pending';
			$this->defaultColumns[] = 'user_noverified';
			$this->defaultColumns[] = 'user_blocked';
			$this->defaultColumns[] = 'user_all';
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
			$this->defaultColumns[] = 'users';
			$this->defaultColumns[] = 'user_pending';
			$this->defaultColumns[] = 'user_noverified';
			$this->defaultColumns[] = 'user_blocked';
			$this->defaultColumns[] = 'user_all';
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

}