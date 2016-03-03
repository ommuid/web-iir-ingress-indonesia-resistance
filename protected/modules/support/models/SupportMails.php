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
 * This is the model class for table "ommu_support_mails".
 *
 * The followings are the available columns in table 'ommu_support_mails':
 * @property string $mail_id
 * @property string $user_id
 * @property string $reply
 * @property string $email
 * @property string $displayname
 * @property string $phone
 * @property string $subject
 * @property string $message
 * @property string $message_reply
 * @property string $creation_date
 */
class SupportMails extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SupportMails the static model class
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
		return 'ommu_support_mails';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, displayname, subject, message', 'required'),
			//array('displayname, phone', 'required', 'on'=>'contactus'),
			array('', 'numerical', 'integerOnly'=>true),
			array('user_id, reply', 'length', 'max'=>11),
			array('phone', 'length', 'max'=>15),
			array('email, displayname', 'length', 'max'=>32),
			array('subject', 'length', 'max'=>64),
			array('email', 'email'),
			array('user_id, displayname, phone, message_reply, creation_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mail_id, reply, user_id, email, displayname, phone, subject, message, message_reply, creation_date', 'safe', 'on'=>'search'),
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
			'mail_id' => 'Mail',
			'user_id' => 'User',
			'reply' => Phrase::trans(23044,1),
			'email' => Phrase::trans(23041,1),
			'displayname' => Phrase::trans(23040,1),
			'phone' => 'Phone',
			'subject' => Phrase::trans(23042,1),
			'message' => Phrase::trans(23043,1),
			'message_reply' => Phrase::trans(23050,1),
			'creation_date' => 'Creation Date',
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

		$criteria->compare('t.mail_id',$this->mail_id);
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.reply',$this->reply);
		$criteria->compare('t.email',$this->email,true);
		$criteria->compare('t.displayname',$this->displayname,true);
		$criteria->compare('t.phone',$this->phone,true);
		$criteria->compare('t.subject',$this->subject,true);
		$criteria->compare('t.message',$this->message,true);
		$criteria->compare('t.message_reply',$this->message,true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
			
		if(!isset($_GET['SupportMails_sort']))
			$criteria->order = 'mail_id DESC';

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
			//$this->defaultColumns[] = 'mail_id';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'reply';
			$this->defaultColumns[] = 'email';
			$this->defaultColumns[] = 'displayname';
			$this->defaultColumns[] = 'phone';
			$this->defaultColumns[] = 'subject';
			$this->defaultColumns[] = 'message';
			$this->defaultColumns[] = 'message_reply';
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
			$this->defaultColumns[] = 'email';
			$this->defaultColumns[] = array(
				'name' => 'displayname',
				'value' => '$data->user_id != 0 ? $data->displayname : "-"',
			);
			$this->defaultColumns[] = 'phone';
			$this->defaultColumns[] = 'subject';
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
				'name' => 'reply',
				'value' => '$data->reply != 0 ? Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/unpublish.png\') ',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>Phrase::trans(588,0),
					0=>Phrase::trans(589,0),
				),
				'type' => 'raw',
			);

		}
		parent::afterConstruct();
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if(!$this->isNewRecord) {
				if($this->message_reply == '') {
					$this->addError('message_reply', Phrase::trans(23051,1));
				}
			}	
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			if(!$this->isNewRecord) {
				$this->reply = Yii::app()->user->id;
			}
		}
		return true;
	}
	
	
	/**
	 * After save attributes
	 */
	protected function afterSave() {
		parent::afterSave();
		if($this->isNewRecord) {
			SupportMailSetting::sendEmail($this->email, $this->displayname, $this->subject, $this->message, 0);
		} else {
			SupportMailSetting::sendEmail($this->email, $this->displayname, 'RE: '.$this->subject, $this->message_reply, 1);
		}
	}

}