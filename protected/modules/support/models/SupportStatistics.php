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
 * This is the model class for table "ommu_support_statistics".
 *
 * The followings are the available columns in table 'ommu_support_statistics':
 * @property string $date_key
 * @property integer $guest_message
 * @property integer $user_message
 * @property integer $guest_message_reply
 * @property integer $user_message_reply
 * @property integer $guest_subscribe
 * @property integer $user_subscribe
 * @property integer $guest_unsubscribe
 * @property integer $user_unsubscribe
 * @property integer $newsletter_signup_success
 */
class SupportStatistics extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SupportStatistics the static model class
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
		return 'ommu_support_statistics';
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
			array('guest_message, user_message, guest_message_reply, user_message_reply, guest_subscribe, user_subscribe, guest_unsubscribe, user_unsubscribe, newsletter_signup_success', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('date_key, guest_message, user_message, guest_message_reply, user_message_reply, guest_subscribe, user_subscribe, guest_unsubscribe, user_unsubscribe, newsletter_signup_success', 'safe', 'on'=>'search'),
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
			'guest_message' => 'Guest Message',
			'user_message' => 'User Message',
			'guest_message_reply' => 'Guest Message Reply',
			'user_message_reply' => 'User Message Reply',
			'guest_subscribe' => 'Guest Subscribe',
			'user_subscribe' => 'User Subscribe',
			'guest_unsubscribe' => 'Guest Unsubscribe',
			'user_unsubscribe' => 'User Unsubscribe',
			'newsletter_signup_success' => 'Newsletter Signup Success',
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
		$criteria->compare('t.guest_message',$this->guest_message);
		$criteria->compare('t.user_message',$this->user_message);
		$criteria->compare('t.guest_message_reply',$this->guest_message_reply);
		$criteria->compare('t.user_message_reply',$this->user_message_reply);
		$criteria->compare('t.guest_subscribe',$this->guest_subscribe);
		$criteria->compare('t.user_subscribe',$this->user_subscribe);
		$criteria->compare('t.guest_unsubscribe',$this->guest_unsubscribe);
		$criteria->compare('t.user_unsubscribe',$this->user_unsubscribe);
		$criteria->compare('t.newsletter_signup_success',$this->newsletter_signup_success);

		if(!isset($_GET['SupportStatistics_sort']))
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
			$this->defaultColumns[] = 'guest_message';
			$this->defaultColumns[] = 'user_message';
			$this->defaultColumns[] = 'guest_message_reply';
			$this->defaultColumns[] = 'user_message_reply';
			$this->defaultColumns[] = 'guest_subscribe';
			$this->defaultColumns[] = 'user_subscribe';
			$this->defaultColumns[] = 'guest_unsubscribe';
			$this->defaultColumns[] = 'user_unsubscribe';
			$this->defaultColumns[] = 'newsletter_signup_success';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			$this->defaultColumns[] = 'date_key';
			$this->defaultColumns[] = 'guest_message';
			$this->defaultColumns[] = 'user_message';
			$this->defaultColumns[] = 'guest_message_reply';
			$this->defaultColumns[] = 'user_message_reply';
			$this->defaultColumns[] = 'guest_subscribe';
			$this->defaultColumns[] = 'user_subscribe';
			$this->defaultColumns[] = 'guest_unsubscribe';
			$this->defaultColumns[] = 'user_unsubscribe';
			$this->defaultColumns[] = 'newsletter_signup_success';
		}
		parent::afterConstruct();
	}
}