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
 * This is the model class for table "ommu_user_statistics".
 *
 * The followings are the available columns in table 'ommu_user_statistics':
 * @property string $date_key
 * @property integer $signup_from_public
 * @property integer $signup_from_admin
 * @property integer $user_change_password
 * @property integer $signup_invite_success
 * @property integer $forgot_password_request
 * @property integer $forgot_password_success
 * @property integer $user_change_email
 * @property integer $invite_new_send
 * @property integer $invite_all_send
 * @property integer $user_blocked
 * @property integer $user_update_info
 */
class UserStatistics extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserStatistics the static model class
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
		return 'ommu_user_statistics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_key', 'required'),
			array('signup_from_public, signup_from_admin, user_change_password, signup_invite_success, forgot_password_request, forgot_password_success, user_change_email, invite_new_send, invite_all_send, user_blocked, user_update_info', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('date_key, signup_from_public, signup_from_admin, user_change_password, signup_invite_success, forgot_password_request, forgot_password_success, user_change_email, invite_new_send, invite_all_send, user_blocked, user_update_info', 'safe', 'on'=>'search'),
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
			'date_key' => 'Date Key',
			'signup_from_public' => 'Signup From Public',
			'signup_from_admin' => 'Signup From Admin',
			'user_change_password' => 'User Change Password',
			'signup_invite_success' => 'Signup Invite Success',
			'forgot_password_request' => 'Forgot Password Request',
			'forgot_password_success' => 'Forgot Password Success',
			'user_change_email' => 'User Change Email',
			'invite_new_send' => 'Invite New Send',
			'invite_all_send' => 'Invite All Send',
			'user_blocked' => 'User Blocked',
			'user_update_info' => 'User Update Info',
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

		$criteria->compare('t.date_key',$this->date_key,true);
		$criteria->compare('t.signup_from_public',$this->signup_from_public);
		$criteria->compare('t.signup_from_admin',$this->signup_from_admin);
		$criteria->compare('t.user_change_password',$this->user_change_password);
		$criteria->compare('t.signup_invite_success',$this->signup_invite_success);
		$criteria->compare('t.forgot_password_request',$this->forgot_password_request);
		$criteria->compare('t.forgot_password_success',$this->forgot_password_success);
		$criteria->compare('t.user_change_email',$this->user_change_email);
		$criteria->compare('t.invite_new_send',$this->invite_new_send);
		$criteria->compare('t.invite_all_send',$this->invite_all_send);
		$criteria->compare('t.user_blocked',$this->user_blocked);
		$criteria->compare('t.user_update_info',$this->user_update_info);

		if(!isset($_GET['UserStatistics_sort']))
			$criteria->order = 'date_key DESC';

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
			//$this->defaultColumns[] = 'date_key';
			$this->defaultColumns[] = 'signup_from_public';
			$this->defaultColumns[] = 'signup_from_admin';
			$this->defaultColumns[] = 'user_change_password';
			$this->defaultColumns[] = 'signup_invite_success';
			$this->defaultColumns[] = 'forgot_password_request';
			$this->defaultColumns[] = 'forgot_password_success';
			$this->defaultColumns[] = 'user_change_email';
			$this->defaultColumns[] = 'invite_new_send';
			$this->defaultColumns[] = 'invite_all_send';
			$this->defaultColumns[] = 'user_blocked';
			$this->defaultColumns[] = 'user_update_info';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			$this->defaultColumns[] = 'date_key';
			$this->defaultColumns[] = 'signup_from_public';
			$this->defaultColumns[] = 'signup_from_admin';
			$this->defaultColumns[] = 'user_change_password';
			$this->defaultColumns[] = 'signup_invite_success';
			$this->defaultColumns[] = 'forgot_password_request';
			$this->defaultColumns[] = 'forgot_password_success';
			$this->defaultColumns[] = 'user_change_email';
			$this->defaultColumns[] = 'invite_new_send';
			$this->defaultColumns[] = 'invite_all_send';
			$this->defaultColumns[] = 'user_blocked';
			$this->defaultColumns[] = 'user_update_info';
		}
		parent::afterConstruct();
	}
}