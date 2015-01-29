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
 * This is the model class for table "ommu_core_settings".
 *
 * The followings are the available columns in table 'ommu_core_settings':
 * @property integer $id
 * @property integer $online
 * @property integer $site_type
 * @property integer $site_admin
 * @property integer $site_email
 * @property string $site_url
 * @property string $site_title
 * @property string $site_keywords
 * @property string $site_description
 * @property string $site_creation
 * @property string $site_dateformat
 * @property string $site_timeformat
 * @property string $construction_date
 * @property string $construction_text
 * @property string $construction_twitter
 * @property integer $signup_username
 * @property integer $signup_approve
 * @property integer $signup_verifyemail
 * @property integer $signup_photo
 * @property integer $signup_welcome
 * @property integer $signup_random
 * @property integer $signup_terms
 * @property integer $signup_invitepage
 * @property integer $signup_inviteonly
 * @property integer $signup_checkemail
 * @property integer $signup_adminemail
 * @property integer $general_profile
 * @property integer $general_invite
 * @property integer $general_search
 * @property integer $general_portal
 * @property string $general_include
 * @property string $general_commenthtml
 * @property string $banned_ips
 * @property string $banned_emails
 * @property string $banned_usernames
 * @property string $banned_words
 * @property integer $spam_comment
 * @property integer $spam_contact
 * @property integer $spam_invite
 * @property integer $spam_login
 * @property integer $spam_failedcount
 * @property integer $spam_signup
 * @property integer $analytic
 * @property string $analytic_id
 * @property string $license_email
 * @property string $license_key
 * @property string $ommu_version
 */
class OmmuSettings extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OmmuSettings the static model class
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
		return 'ommu_core_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_url, site_title, site_keywords, site_description, site_dateformat, site_timeformat', 'required', 'on'=>'general'),
			array('general_commenthtml, spam_failedcount', 'required', 'on'=>'banned'),
			array('signup_numgiven', 'required', 'on'=>'signup'),
			//array('analytic_id', 'required', 'on'=>'analytic'),
			array('id, online, site_type, site_admin, site_email, signup_username, signup_approve, signup_verifyemail, signup_photo, signup_welcome, signup_random, signup_terms, signup_invitepage, signup_inviteonly, signup_checkemail, signup_numgiven, signup_adminemail, general_profile, general_invite, general_search, general_portal, lang_allow, lang_autodetect, lang_anonymous, spam_comment, spam_contact, spam_invite, spam_login, spam_failedcount, spam_signup, analytic', 'numerical', 'integerOnly'=>true),
			array('signup_numgiven', 'length', 'max'=>3),
			array('ommu_version', 'length', 'max'=>8),
			array('site_url, analytic_id, license_email, license_key', 'length', 'max'=>32),
			array('site_title, site_keywords, site_description, general_commenthtml', 'length', 'max'=>256),
			array('license_email', 'email'),
			array('site_creation, construction_date, construction_text, construction_twitter, general_include, banned_ips, banned_emails, banned_usernames, banned_words', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, online, site_type, site_admin, site_email, site_url, site_title, site_keywords, site_description, construction_date, construction_text, construction_twitter, site_creation, site_dateformat, site_timeformat, signup_username, signup_approve, signup_verifyemail, signup_photo, signup_welcome, signup_random, signup_terms, signup_invitepage, signup_inviteonly, signup_checkemail, signup_adminemail, general_profile, general_invite, general_search, general_portal, general_include, general_commenthtml, banned_ips, banned_emails, banned_usernames, banned_words, spam_comment, spam_contact, spam_invite, spam_login, spam_failedcount, spam_signup, analytic, analytic_id, license_email, license_key, ommu_version', 'safe', 'on'=>'search'),
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
			'id' => Phrase::trans(133,0),
			'online' => Phrase::trans(101,0),
			'site_type' => Phrase::trans(439,0),
			'site_admin' => Phrase::trans(440,0),
			'site_email' => Phrase::trans(441,0),
			'site_url' => Phrase::trans(107,0),
			'site_title' => Phrase::trans(105,0),
			'site_keywords' => Phrase::trans(110,0),
			'site_description' => Phrase::trans(108,0),
			'site_creation' => Phrase::trans(438,0),
			'site_dateformat' => Phrase::trans(512,0),
			'site_timeformat' => Phrase::trans(513,0),
			'construction_date' => Phrase::trans(315,0),
			'construction_text' => Phrase::trans(316,0),
			'construction_twitter' => Phrase::trans(319,0),
			'signup_username' => Phrase::trans(46,0),
			'signup_approve' => Phrase::trans(11,0),
			'signup_verifyemail' => Phrase::trans(34,0),
			'signup_photo' => Phrase::trans(7,0),
			'signup_welcome' => Phrase::trans(15,0),
			'signup_random' => Phrase::trans(38,0),
			'signup_terms' => Phrase::trans(42,0),
			'signup_invitepage' => Phrase::trans(30,0),
			'signup_inviteonly' => Phrase::trans(19,0),
			'signup_checkemail' => Phrase::trans(437,0),
			'signup_numgiven' => Phrase::trans(29,0),
			'signup_adminemail' => Phrase::trans(50,0),
			'general_profile' => Phrase::trans(95,0),
			'general_invite' => Phrase::trans(99,0),
			'general_search' => Phrase::trans(97,0),
			'general_portal' => Phrase::trans(98,0),
			'general_include' => Phrase::trans(126,0),
			'general_commenthtml' => Phrase::trans(92,0),
			'lang_allow' => Phrase::trans(434,0),
			'lang_autodetect' => Phrase::trans(435,0),
			'lang_anonymous' => Phrase::trans(92,0),
			'banned_ips' => Phrase::trans(65,0),
			'banned_emails' => Phrase::trans(67,0),
			'banned_usernames' => Phrase::trans(69,0),
			'banned_words' => Phrase::trans(71,0),
			'spam_comment' => Phrase::trans(88,0),
			'spam_contact' => Phrase::trans(84,0),
			'spam_invite' => Phrase::trans(73,0),
			'spam_login' => Phrase::trans(77,0),
			'spam_failedcount' => Phrase::trans(83,0),
			'spam_signup' => Phrase::trans(54,0),
			'analytic' => Phrase::trans(61,0),
			'analytic_id' => Phrase::trans(62,0),
			'license_email' => Phrase::trans(433,0),
			'license_key' => Phrase::trans(432,0),
			'ommu_version' => Phrase::trans(431,0),
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
		$criteria->compare('t.online',$this->online);
		$criteria->compare('t.site_type',$this->site_type);
		$criteria->compare('t.site_admin',$this->site_admin);
		$criteria->compare('t.site_email',$this->site_email);
		$criteria->compare('t.site_url',$this->site_url,true);
		$criteria->compare('t.site_title',$this->site_title,true);
		$criteria->compare('t.site_keywords',$this->site_keywords,true);
		$criteria->compare('t.site_description',$this->site_description,true);
		$criteria->compare('t.site_creation',$this->site_creation,true);
		$criteria->compare('t.site_dateformat',$this->site_dateformat,true);
		$criteria->compare('t.site_timeformat',$this->site_timeformat,true);
		$criteria->compare('t.construction_date',$this->construction_date);
		$criteria->compare('t.construction_text',$this->construction_text,true);
		$criteria->compare('t.construction_twitter',$this->construction_twitter,true);
		$criteria->compare('t.signup_username',$this->signup_username);
		$criteria->compare('t.signup_approve',$this->signup_approve);
		$criteria->compare('t.signup_verifyemail',$this->signup_verifyemail);
		$criteria->compare('t.signup_photo',$this->signup_photo);
		$criteria->compare('t.signup_welcome',$this->signup_welcome);
		$criteria->compare('t.signup_random',$this->signup_random);
		$criteria->compare('t.signup_terms',$this->signup_terms);
		$criteria->compare('t.signup_invitepage',$this->signup_invitepage);
		$criteria->compare('t.signup_inviteonly',$this->signup_inviteonly);
		$criteria->compare('t.signup_checkemail',$this->signup_checkemail);
		$criteria->compare('t.signup_adminemail',$this->signup_adminemail);
		$criteria->compare('t.general_profile',$this->general_profile);
		$criteria->compare('t.general_invite',$this->general_invite);
		$criteria->compare('t.general_search',$this->general_search);
		$criteria->compare('t.general_portal',$this->general_portal);
		$criteria->compare('t.general_include',$this->general_include,true);
		$criteria->compare('t.general_commenthtml',$this->general_commenthtml,true);
		$criteria->compare('t.banned_ips',$this->banned_ips,true);
		$criteria->compare('t.banned_emails',$this->banned_emails,true);
		$criteria->compare('t.banned_usernames',$this->banned_usernames,true);
		$criteria->compare('t.banned_words',$this->banned_words,true);
		$criteria->compare('t.spam_comment',$this->spam_comment);
		$criteria->compare('t.spam_contact',$this->spam_contact);
		$criteria->compare('t.spam_invite',$this->spam_invite);
		$criteria->compare('t.spam_login',$this->spam_login);
		$criteria->compare('t.spam_failedcount',$this->spam_failedcount);
		$criteria->compare('t.spam_signup',$this->spam_signup);
		$criteria->compare('t.analytic',$this->analytic);
		$criteria->compare('t.analytic_id',$this->analytic_id,true);
		$criteria->compare('t.license_email',$this->license_email,true);
		$criteria->compare('t.license_key',$this->license_key,true);
		$criteria->compare('t.ommu_version',$this->ommu_version,true);

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
			$this->defaultColumns[] = 'online';
			$this->defaultColumns[] = 'site_type';
			$this->defaultColumns[] = 'site_admin';
			$this->defaultColumns[] = 'site_email';
			$this->defaultColumns[] = 'site_url';
			$this->defaultColumns[] = 'site_title';
			$this->defaultColumns[] = 'site_keywords';
			$this->defaultColumns[] = 'site_description';
			$this->defaultColumns[] = 'site_creation';
			$this->defaultColumns[] = 'site_dateformat';
			$this->defaultColumns[] = 'site_timeformat';
			$this->defaultColumns[] = 'construction_date';
			$this->defaultColumns[] = 'construction_text';
			$this->defaultColumns[] = 'construction_twitter';
			$this->defaultColumns[] = 'signup_username';
			$this->defaultColumns[] = 'signup_approve';
			$this->defaultColumns[] = 'signup_verifyemail';
			$this->defaultColumns[] = 'signup_photo';
			$this->defaultColumns[] = 'signup_welcome';
			$this->defaultColumns[] = 'signup_random';
			$this->defaultColumns[] = 'signup_terms';
			$this->defaultColumns[] = 'signup_invitepage';
			$this->defaultColumns[] = 'signup_inviteonly';
			$this->defaultColumns[] = 'signup_checkemail';
			$this->defaultColumns[] = 'signup_adminemail';
			$this->defaultColumns[] = 'general_profile';
			$this->defaultColumns[] = 'general_invite';
			$this->defaultColumns[] = 'general_search';
			$this->defaultColumns[] = 'general_portal';
			$this->defaultColumns[] = 'general_include';
			$this->defaultColumns[] = 'general_commenthtml';
			$this->defaultColumns[] = 'banned_ips';
			$this->defaultColumns[] = 'banned_emails';
			$this->defaultColumns[] = 'banned_usernames';
			$this->defaultColumns[] = 'banned_words';
			$this->defaultColumns[] = 'spam_comment';
			$this->defaultColumns[] = 'spam_contact';
			$this->defaultColumns[] = 'spam_invite';
			$this->defaultColumns[] = 'spam_login';
			$this->defaultColumns[] = 'spam_failedcount';
			$this->defaultColumns[] = 'spam_signup';
			$this->defaultColumns[] = 'analytic';
			$this->defaultColumns[] = 'analytic_id';
			$this->defaultColumns[] = 'license_email';
			$this->defaultColumns[] = 'license_key';
			$this->defaultColumns[] = 'ommu_version';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			$this->defaultColumns[] = 'id';
			$this->defaultColumns[] = 'online';
			$this->defaultColumns[] = 'site_type';
			$this->defaultColumns[] = 'site_admin';
			$this->defaultColumns[] = 'site_email';
			$this->defaultColumns[] = 'site_url';
			$this->defaultColumns[] = 'site_title';
			$this->defaultColumns[] = 'site_keywords';
			$this->defaultColumns[] = 'site_description';
			$this->defaultColumns[] = 'site_creation';
			$this->defaultColumns[] = 'site_dateformat';
			$this->defaultColumns[] = 'site_timeformat';
			$this->defaultColumns[] = 'construction_date';
			$this->defaultColumns[] = 'construction_text';
			$this->defaultColumns[] = 'construction_twitter';
			$this->defaultColumns[] = 'signup_username';
			$this->defaultColumns[] = 'signup_approve';
			$this->defaultColumns[] = 'signup_verifyemail';
			$this->defaultColumns[] = 'signup_photo';
			$this->defaultColumns[] = 'signup_welcome';
			$this->defaultColumns[] = 'signup_random';
			$this->defaultColumns[] = 'signup_terms';
			$this->defaultColumns[] = 'signup_invitepage';
			$this->defaultColumns[] = 'signup_inviteonly';
			$this->defaultColumns[] = 'signup_checkemail';
			$this->defaultColumns[] = 'signup_adminemail';
			$this->defaultColumns[] = 'general_profile';
			$this->defaultColumns[] = 'general_invite';
			$this->defaultColumns[] = 'general_search';
			$this->defaultColumns[] = 'general_portal';
			$this->defaultColumns[] = 'general_include';
			$this->defaultColumns[] = 'general_commenthtml';
			$this->defaultColumns[] = 'banned_ips';
			$this->defaultColumns[] = 'banned_emails';
			$this->defaultColumns[] = 'banned_usernames';
			$this->defaultColumns[] = 'banned_words';
			$this->defaultColumns[] = 'spam_comment';
			$this->defaultColumns[] = 'spam_contact';
			$this->defaultColumns[] = 'spam_invite';
			$this->defaultColumns[] = 'spam_login';
			$this->defaultColumns[] = 'spam_failedcount';
			$this->defaultColumns[] = 'spam_signup';
			$this->defaultColumns[] = 'analytic';
			$this->defaultColumns[] = 'analytic_id';
			$this->defaultColumns[] = 'license_email';
			$this->defaultColumns[] = 'license_key';
			$this->defaultColumns[] = 'ommu_version';
		}
		parent::afterConstruct();
	}

	/**
	 * User get information
	 */
	public static function getInfo($column)
	{
		$model = self::model()->findByPk(1,array(
			'select' => $column
		));
		return $model->$column;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {		
			if($this->online == 0) {
				if($this->construction_date == '') {
					$this->addError('construction_date', Phrase::trans(317,0));
				}
				if($this->construction_text == '') {
					$this->addError('construction_text', Phrase::trans(318,0));
				}
				if($this->construction_twitter == '') {
					$this->addError('construction_twitter', Phrase::trans(320,0));
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
			$this->construction_date = date('Y-m-d', strtotime($this->construction_date));
		}
		return true;
	}

}