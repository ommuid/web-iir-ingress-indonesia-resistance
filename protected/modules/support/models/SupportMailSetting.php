<?php
/**
 * SupportMailSetting
 * version: 0.2.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Support
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
 * @property string $modified_date
 * @property string $modified_id
 */
class SupportMailSetting extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $modified_search;

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
			array('id, mail_count, mail_queueing, mail_smtp, smtp_authentication, smtp_ssl, modified_id', 'numerical', 'integerOnly'=>true),
			array('mail_contact, mail_name, mail_from, smtp_address, smtp_username, smtp_password', 'length', 'max'=>32),
			array('smtp_port', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mail_contact, mail_name, mail_from, mail_count, mail_queueing, mail_smtp, smtp_address, smtp_port, smtp_authentication, smtp_username, smtp_password, smtp_ssl, modified_date, modified_id,
				modified_search', 'safe', 'on'=>'search'),
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
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mail_contact' => Yii::t('attribute', 'Contact Form Email'),
			'mail_name' => Yii::t('attribute', 'From Name'),
			'mail_from' => Yii::t('attribute', 'From Address'),
			'mail_count' => Yii::t('attribute', 'Mail Count'),
			'mail_queueing' => Yii::t('attribute', 'Email Queue'),
			'mail_smtp' => Yii::t('attribute', 'Send through SMTP'),
			'smtp_address' => Yii::t('attribute', 'SMTP Server Address'),
			'smtp_port' => Yii::t('attribute', 'SMTP Server Port'),
			'smtp_authentication' => Yii::t('attribute', 'SMTP Authentication?'),
			'smtp_username' => Yii::t('attribute', 'SMTP Username'),
			'smtp_password' => Yii::t('attribute', 'SMTP Password'),
			'smtp_ssl' => Yii::t('attribute', 'Use SSL or TLS?'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified ID'),
			'modified_search' => Yii::t('attribute', 'Modified'),
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
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id',$this->modified_id);
		
		// Custom Search
		$criteria->with = array(
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname',
			),
		);
		$criteria->compare('modified.displayname',strtolower($this->modified_search), true);
			
		if(!isset($_GET['SupportMailSetting_sort']))
			$criteria->order = 't.id DESC';

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
			$this->defaultColumns[] = 'modified_date';
			$this->defaultColumns[] = 'modified_id';
			$this->defaultColumns[] = array(
				'name' => 'modified_search',
				'value' => '$data->modified->displayname',
			);

		}
		parent::afterConstruct();
	}

	/**
	 * User get information
	 */
	public static function getInfo($column=null)
	{
		if($column != null) {
			$model = self::model()->findByPk(1,array(
				'select' => $column
			));
			return $model->$column;
			
		} else {
			$model = self::model()->findByPk(1);
			return $model;			
		}
	}

    /**
	 * Sent Email
	 */
	public static function sendEmail($to_email=null, $to_name=null, $subject, $message, $cc=null, $attachment=null) 
	{
		ini_set('max_execution_time', 0);
		ob_start();
		
		$model = self::model()->findByPk(1,array(
			'select' => 'mail_contact, mail_name, mail_from, mail_smtp, smtp_address, smtp_port, smtp_username, smtp_password, smtp_ssl',
		));
		$setting = OmmuSettings::model()->findByPk(1, array(
			'select' => 'site_title',
		));
		
		$debug = Yii::app()->params['debug']['send_email'];
		$debugStatus = $debug['status'];
		$debugContent = $debug['content'];
		$debugEmail = $debug['email'];
		
		if($debugStatus == 1 && in_array(Yii::app()->request->serverName, array('localhost','127.0.0.1','192.168.3.13')) && $debugContent == 'file_put_contents') {
			file_put_contents(Utility::getUrlTitle($subject).'.htm', $message);
			
		} else {
			if($debugStatus == 1 && in_array(Yii::app()->request->serverName, array('localhost','127.0.0.1','192.168.3.13')) && $debugContent == 'send_email')
				$to_email = $to_name = $debugEmail;
				
			Yii::import('application.extensions.phpmailer.JPhpMailer');
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
				if($model->smtp_ssl != 0)
					$mail->SMTPSecure	= $model->smtp_ssl == 1 ? "tls" : "ssl";	// Enable encryption, 'ssl' also accepted

			} else {
				//live server 
				$mail->IsMail();
			}
			
			if($to_email != null && $to_name != null) {
				$mail->SetFrom($model->mail_from, $model->mail_name);
				$mail->AddReplyTo($model->mail_from, $model->mail_name);			
				$mail->AddAddress($to_email, $to_name);
			} else {
				$mail->SetFrom($model->mail_from, Yii::t('phrase', '[System]').' '.$setting->site_title);
				$mail->AddReplyTo($model->mail_from, Yii::t('phrase', '[System]').' '.$setting->site_title);
				$mail->AddAddress($model->mail_contact, $model->mail_name);
			}
				
			// cc
			if ($cc != null && count($cc) > 0) {
				foreach ($cc as $email => $name)
					$mail->AddAddress($email, $name);
			}
			// attachment
			if ($attachment != null)
				$mail->addAttachment($attachment);
			
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

		ob_end_flush();
    }

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->mail_smtp == '1') {
				if($this->smtp_address == '')
					$this->addError('smtp_address', Yii::t('phrase', 'SMTP Server Address cannot be blank.'));
				
				if($this->smtp_port == '')
					$this->addError('smtp_port', Yii::t('phrase', 'SMTP Server Port cannot be blank.'));
				
				if($this->smtp_authentication == '1') {
					if($this->smtp_username == '')
						$this->addError('smtp_username', Yii::t('phrase', 'SMTP Username cannot be blank.'));
					if($this->smtp_password == '')
						$this->addError('smtp_password', Yii::t('phrase', 'SMTP Password cannot be blank.'));
				}
			}

			$this->modified_id = Yii::app()->user->id;
		}
		return true;
	}

}