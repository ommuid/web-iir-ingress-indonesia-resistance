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
 * This is the model class for table "ommu_support_mail_setting".
 *
 * The followings are the available columns in table 'ommu_support_mail_setting':
 * @property integer $id
 * @property string $mail_contact
 * @property string $mail_name
 * @property string $mail_from
 * @property integer $mail_count
 * @property integer $mail_queueing
 * @property integer $mail_smtp
 * @property string $smtp_address
 * @property string $smtp_port
 * @property integer $smtp_authentication
 * @property string $smtp_username
 * @property string $smtp_password
 * @property integer $smtp_ssl
 */
class SupportMailSetting extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SupportMailSetting the static model class
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
		return 'ommu_support_mail_setting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mail_contact, mail_name, mail_from, mail_count', 'required'),
			array('id, mail_count, mail_queueing, mail_smtp, smtp_authentication, smtp_ssl', 'numerical', 'integerOnly'=>true),
			array('mail_contact, mail_name, mail_from, smtp_address, smtp_username, smtp_password', 'length', 'max'=>32),
			array('smtp_port', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mail_contact, mail_name, mail_from, mail_count, mail_queueing, mail_smtp, smtp_address, smtp_port, smtp_authentication, smtp_username, smtp_password, smtp_ssl', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'mail_contact' => Phrase::trans(23003,1),
			'mail_name' => Phrase::trans(23005,1),
			'mail_from' => Phrase::trans(23007,1),
			'mail_count' => Phrase::trans(23009,1),
			'mail_queueing' => Phrase::trans(23011,1),
			'mail_smtp' => Phrase::trans(23015,1),
			'smtp_address' => Phrase::trans(23019,1),
			'smtp_port' => Phrase::trans(23020,1),
			'smtp_authentication' => Phrase::trans(23022,1),
			'smtp_username' => Phrase::trans(23030,1),
			'smtp_password' => Phrase::trans(23031,1),
			'smtp_ssl' => Phrase::trans(23026,1),
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

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.mail_contact',$this->mail_contact,true);
		$criteria->compare('t.mail_name',$this->mail_name,true);
		$criteria->compare('t.mail_from',$this->mail_from,true);
		$criteria->compare('t.mail_count',$this->mail_count);
		$criteria->compare('t.mail_queueing',$this->mail_queueing);
		$criteria->compare('t.mail_smtp',$this->mail_smtp);
		$criteria->compare('t.smtp_address',$this->smtp_address,true);
		$criteria->compare('t.smtp_port',$this->smtp_port,true);
		$criteria->compare('t.smtp_authentication',$this->smtp_authentication);
		$criteria->compare('t.smtp_username',$this->smtp_username,true);
		$criteria->compare('t.smtp_password',$this->smtp_password,true);
		$criteria->compare('t.smtp_ssl',$this->smtp_ssl);

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
			//$this->defaultColumns[] = 'id';
			$this->defaultColumns[] = 'mail_contact';
			$this->defaultColumns[] = 'mail_name';
			$this->defaultColumns[] = 'mail_from';
			$this->defaultColumns[] = 'mail_count';
			$this->defaultColumns[] = 'mail_queueing';
			$this->defaultColumns[] = 'mail_smtp';
			$this->defaultColumns[] = 'smtp_address';
			$this->defaultColumns[] = 'smtp_port';
			$this->defaultColumns[] = 'smtp_authentication';
			$this->defaultColumns[] = 'smtp_username';
			$this->defaultColumns[] = 'smtp_password';
			$this->defaultColumns[] = 'smtp_ssl';
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
			$this->defaultColumns[] = 'mail_contact';
			$this->defaultColumns[] = 'mail_name';
			$this->defaultColumns[] = 'mail_from';
			$this->defaultColumns[] = 'mail_count';
			$this->defaultColumns[] = 'mail_queueing';
			$this->defaultColumns[] = 'mail_smtp';
			$this->defaultColumns[] = 'smtp_address';
			$this->defaultColumns[] = 'smtp_port';
			$this->defaultColumns[] = 'smtp_authentication';
			$this->defaultColumns[] = 'smtp_username';
			$this->defaultColumns[] = 'smtp_password';
			$this->defaultColumns[] = 'smtp_ssl';

		}
		parent::afterConstruct();
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->mail_smtp == '1') {
				if($this->smtp_address == '') {
					$this->addError('smtp_address', Phrase::trans(23032,1));
				}
				if($this->smtp_port == '') {
					$this->addError('smtp_port', Phrase::trans(23033,1));
				}
				if($this->smtp_authentication == '1') {
					if($this->smtp_username == '') {
						$this->addError('smtp_username', Phrase::trans(23034,1));
					}
					if($this->smtp_password == '') {
						$this->addError('smtp_password', Phrase::trans(23035,1));
					}
				}
			}		
		}
		return true;
	}

    /**
	 * Sent Email
	 */
	public static function sendEmail($to_email, $to_name, $subject, $message, $type) {
		Yii::import('application.extensions.phpmailer.JPhpMailer');
		$model = self::model()->findByPk(1,array(
			'select' => 'mail_contact, mail_name, mail_from, mail_smtp, smtp_address, smtp_port, smtp_username, smtp_password, smtp_ssl',
		));

		$mail=new JPhpMailer;

		if($model->mail_smtp == 1 || $_SERVER["SERVER_ADDR"]=='127.0.0.1' || $_SERVER["HTTP_HOST"]=='localhost') {
			//in localhost or testing condition
			//smtp google 
			$mail->IsSMTP();								// Set mailer to use SMTP
			$mail->Host			= $model->smtp_address;		// Specify main and backup server
			$mail->Port			= $model->smtp_port;		// set the SMTP port
			$mail->SMTPAuth		= true;						// Enable SMTP authentication
			$mail->Username		= $model->smtp_username;	// SES SMTP  username
			$mail->Password		= $model->smtp_password;	// SES SMTP password
			if($model->smtp_ssl != 0) {
				$mail->SMTPSecure	= $model->smtp_ssl == 1 ? "tls" : "ssl";	// Enable encryption, 'ssl' also accepted
			}

		} else {
			//live server 
			$mail->IsMail();
		}
		
		/**
		 * 0 = to admin
		 * 1 = to user
		 */
		if($type == '0') {
			$mail->SetFrom($to_email, $to_name);
			$mail->AddReplyTo($to_email, $to_name);
			$mail->AddAddress($model->mail_contact, $model->mail_name);
		} else {
			$mail->SetFrom($model->mail_from, $model->mail_name);
			$mail->AddReplyTo($model->mail_from, $model->mail_name);
			$mail->AddAddress($to_email, $to_name);
		}
		$mail->Subject = $subject;
		$mail->MsgHTML($message);

		if($mail->Send()) {
			return true;
			//echo 'send';
		} else {
			return false;
			//echo 'no send';
		}
    }

}