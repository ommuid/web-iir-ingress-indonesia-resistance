<?php
/**
 * ViewUsers
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2015 Ommu Platform (opensource.ommu.co)
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
 * This is the model class for table "_view_users".
 *
 * The followings are the available columns in table '_view_users':
 * @property string $user_id
 * @property string $token_key
 * @property string $token_password
 * @property string $token_oauth
 * @property string $emails
 * @property string $email_lastchange_date
 * @property string $usernames
 * @property string $username_lastchange_date
 * @property string $passwords
 * @property string $password_lastchange_date
 * @property string $logins
 * @property string $lastlogin_date
 * @property string $lastlogin_from
 */
class ViewUsers extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewUsers the static model class
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
		return '_view_users';
	}

	/**
	 * @return string the primarykey column
	 */
	public function primaryKey()
	{
		return 'user_id';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that 
		// will receive user inputs. 
		return array( 
			array('user_id', 'length', 'max'=>11),
			array('token_key, token_password, token_oauth, lastlogin_from', 'length', 'max'=>32),
			array('emails, usernames, passwords, logins', 'length', 'max'=>21),
			array('email_lastchange_date, username_lastchange_date, password_lastchange_date, lastlogin_date', 'safe'),
			// The following rule is used by search(). 
			// @todo Please remove those attributes that should not be searched. 
			array('user_id, token_key, token_password, token_oauth, emails, email_lastchange_date, usernames, username_lastchange_date, passwords, password_lastchange_date, logins, lastlogin_date, lastlogin_from', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => Yii::t('attribute', 'User'),
			'token_key' => Yii::t('attribute', 'Token Key'),
			'token_password' => Yii::t('attribute', 'Token Password'),
			'token_oauth' => Yii::t('attribute', 'Token Oauth'),
			'emails' => Yii::t('attribute', 'Emails'),
			'email_lastchange_date' => Yii::t('attribute', 'Email Lastchange Date'),
			'usernames' => Yii::t('attribute', 'Usernames'),
			'username_lastchange_date' => Yii::t('attribute', 'Username Lastchange Date'),
			'passwords' => Yii::t('attribute', 'Passwords'),
			'password_lastchange_date' => Yii::t('attribute', 'Password Lastchange Date'),
			'logins' => Yii::t('attribute', 'Logins'),
			'lastlogin_date' => Yii::t('attribute', 'Lastlogin Date'),
			'lastlogin_from' => Yii::t('attribute', 'Lastlogin From'),			
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
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.token_key',strtolower($this->token_key),true);
		$criteria->compare('t.token_password',strtolower($this->token_password),true);
		$criteria->compare('t.token_oauth',strtolower($this->token_oauth),true);
		$criteria->compare('t.emails',$this->emails);
		if($this->email_lastchange_date != null && !in_array($this->email_lastchange_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.email_lastchange_date)',date('Y-m-d', strtotime($this->email_lastchange_date)));
		$criteria->compare('t.usernames',$this->usernames);
		if($this->username_lastchange_date != null && !in_array($this->username_lastchange_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.username_lastchange_date)',date('Y-m-d', strtotime($this->username_lastchange_date)));
		$criteria->compare('t.passwords',$this->passwords);
		if($this->password_lastchange_date != null && !in_array($this->password_lastchange_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.password_lastchange_date)',date('Y-m-d', strtotime($this->password_lastchange_date)));
		$criteria->compare('t.logins',$this->logins);
		if($this->lastlogin_date != null && !in_array($this->lastlogin_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.lastlogin_date)',date('Y-m-d', strtotime($this->lastlogin_date)));
		$criteria->compare('t.lastlogin_from',strtolower($this->lastlogin_from),true);

		if(!isset($_GET['ViewUsers_sort']))
			$criteria->order = 't.user_id DESC';

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
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'token_key';
			$this->defaultColumns[] = 'token_password';
			$this->defaultColumns[] = 'token_oauth';
			$this->defaultColumns[] = 'emails';
			$this->defaultColumns[] = 'email_lastchange_date';
			$this->defaultColumns[] = 'usernames';
			$this->defaultColumns[] = 'username_lastchange_date';
			$this->defaultColumns[] = 'passwords';
			$this->defaultColumns[] = 'password_lastchange_date';
			$this->defaultColumns[] = 'logins';
			$this->defaultColumns[] = 'lastlogin_date';
			$this->defaultColumns[] = 'lastlogin_from';
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
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'token_key';
			$this->defaultColumns[] = 'token_password';
			$this->defaultColumns[] = 'token_oauth';
			$this->defaultColumns[] = 'emails';
			$this->defaultColumns[] = 'email_lastchange_date';
			$this->defaultColumns[] = 'usernames';
			$this->defaultColumns[] = 'username_lastchange_date';
			$this->defaultColumns[] = 'passwords';
			$this->defaultColumns[] = 'password_lastchange_date';
			$this->defaultColumns[] = 'logins';
			$this->defaultColumns[] = 'lastlogin_date';
			$this->defaultColumns[] = 'lastlogin_from';
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