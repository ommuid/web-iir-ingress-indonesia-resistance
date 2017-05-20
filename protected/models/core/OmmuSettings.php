<?php
/**
 * OmmuSettings
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
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
 * @property integer $site_oauth
 * @property integer $site_type
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
 * @property string $event_startdate
 * @property string $event_finishdate
 * @property string $event_tag
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
 * @property string $analytic_profile_id
 * @property string $license_email
 * @property string $license_key
 * @property string $ommu_version
 * @property string $modified_date
 * @property string $modified_id
 */
class OmmuSettings extends CActiveRecord
{
	public $defaultColumns = array();
	public $event;
	
	// Variable Search
	public $modified_search;

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
			array('site_url, site_title, site_keywords, site_description, site_dateformat, site_timeformat,
				event', 'required', 'on'=>'general'),
			array('general_commenthtml, spam_failedcount', 'required', 'on'=>'banned'),
			array('signup_numgiven', 'required', 'on'=>'signup'),
			array('analytic_id, analytic_profile_id', 'required', 'on'=>'analytic'),
			array('id, online, site_oauth, site_type, site_email, signup_username, signup_approve, signup_verifyemail, signup_photo, signup_welcome, signup_random, signup_terms, signup_invitepage, signup_inviteonly, signup_checkemail, signup_numgiven, signup_adminemail, general_profile, general_invite, general_search, general_portal, lang_allow, lang_autodetect, lang_anonymous, spam_comment, spam_contact, spam_invite, spam_login, spam_failedcount, spam_signup, analytic', 'numerical', 'integerOnly'=>true),
			array('signup_numgiven', 'length', 'max'=>3),
			array('ommu_version', 'length', 'max'=>8),
			array('site_url, analytic_id, analytic_profile_id, license_email, license_key', 'length', 'max'=>32),
			array('site_title, site_keywords, site_description, general_commenthtml', 'length', 'max'=>256),
			array('license_email', 'email'),
			array('site_creation, construction_date, construction_text, event_startdate, event_finishdate, event_tag, general_include, banned_ips, banned_emails, banned_usernames, banned_words, analytic_id, analytic_profile_id,
				event', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, online, site_oauth, site_type, site_email, site_url, site_title, site_keywords, site_description, construction_date, construction_text, construction_twitter, site_creation, site_dateformat, site_timeformat, signup_username, signup_approve, signup_verifyemail, signup_photo, signup_welcome, signup_random, signup_terms, signup_invitepage, signup_inviteonly, signup_checkemail, signup_adminemail, general_profile, general_invite, general_search, general_portal, general_include, general_commenthtml, banned_ips, banned_emails, banned_usernames, banned_words, spam_comment, spam_contact, spam_invite, spam_login, spam_failedcount, spam_signup, analytic, analytic_id, analytic_profile_id, license_email, license_key, ommu_version, modified_date, modified_id, 
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
			'id' => Yii::t('attribute', 'ID'),
			'online' => Yii::t('attribute', 'Maintenance Mode'),
			'site_oauth' => Yii::t('attribute', 'Oauth'),
			'site_type' => Yii::t('attribute', 'Site Type'),
			'site_email' => Yii::t('attribute', 'Site Email'),
			'site_url' => Yii::t('attribute', 'Site Url'),
			'site_title' => Yii::t('attribute', 'Site Title'),
			'site_keywords' => Yii::t('attribute', 'Site Keywords'),
			'site_description' => Yii::t('attribute', 'Site Description'),
			'site_creation' => Yii::t('attribute', 'Site Creation'),
			'site_dateformat' => Yii::t('attribute', 'Site Dateformat'),
			'site_timeformat' => Yii::t('attribute', 'Site Timeformat'),
			'construction_date' => Yii::t('attribute', 'Maintenance Date'),
			'construction_text' => Yii::t('attribute', 'Maintenance Text'),
			'event_startdate' => Yii::t('attribute', 'Event Startdate'),
			'event_finishdate' => Yii::t('attribute', 'Event Finishdate'),
			'event_tag' => Yii::t('attribute', 'Event Tag'),
			'signup_username' => Yii::t('attribute', 'Enable Profile Address?'),
			'signup_approve' => Yii::t('attribute', 'Enable Users?'),
			'signup_verifyemail' => Yii::t('attribute', 'Verify Email Address?'),
			'signup_photo' => Yii::t('attribute', 'User Photo Upload'),
			'signup_welcome' => Yii::t('attribute', 'Send Welcome Email?'),
			'signup_random' => Yii::t('attribute', 'Generate Random Passwords?'),
			'signup_terms' => Yii::t('attribute', 'Require users to agree to your terms of service?'),
			'signup_invitepage' => Yii::t('attribute', 'Show "Invite Friends" Page?'),
			'signup_inviteonly' => Yii::t('attribute', 'Invite Only?'),
			'signup_checkemail' => Yii::t('attribute', 'Signup Checkemail'),
			'signup_numgiven' => Yii::t('attribute', 'Signup Numgiven'),
			'signup_adminemail' => Yii::t('attribute', 'Notify Admin by email when user signs up?'),
			'general_profile' => Yii::t('attribute', 'Member Profiles'),
			'general_invite' => Yii::t('attribute', 'Invite Page'),
			'general_search' => Yii::t('attribute', 'Search Page'),
			'general_portal' => Yii::t('attribute', 'Portal Page'),
			'general_include' => Yii::t('attribute', 'Head Scripts/Styles'),
			'general_commenthtml' => Yii::t('attribute', 'HTML in Comments'),
			'lang_allow' => Yii::t('attribute', 'Lang Allow'),
			'lang_autodetect' => Yii::t('attribute', 'Lang Autodetect'),
			'lang_anonymous' => Yii::t('attribute', 'Lang Anonymous'),
			'banned_ips' => Yii::t('attribute', 'Ban Users by IP Address'),
			'banned_emails' => Yii::t('attribute', 'Ban Users by Email Address'),
			'banned_usernames' => Yii::t('attribute', 'Ban Users by Username'),
			'banned_words' => Yii::t('attribute', 'Censored Words on Profiles and Plugins'),
			'spam_comment' => Yii::t('attribute', 'Require users to enter validation code when commenting?'),
			'spam_contact' => Yii::t('attribute', 'Require users to enter validation code when using the contact form?'),
			'spam_invite' => Yii::t('attribute', 'Require users to enter validation code when inviting others?'),
			'spam_login' => Yii::t('attribute', 'Require users to enter validation code when logging in?'),
			'spam_failedcount' => Yii::t('attribute', 'Spam Failedcount'),
			'spam_signup' => Yii::t('attribute', 'Require Users to Enter a Verification Code?'),
			'analytic' => Yii::t('attribute', 'Analytic'),
			'analytic_id' => Yii::t('attribute', 'Analytic'),
			'analytic_profile_id' => Yii::t('attribute', 'Profile ID'),
			'license_email' => Yii::t('attribute', 'License Email'),
			'license_key' => Yii::t('attribute', 'License Key'),
			'ommu_version' => Yii::t('attribute', 'Ommu Version'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'event' => Yii::t('attribute', 'Event'),
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
		$criteria->compare('t.online',$this->online);
		$criteria->compare('t.site_oauth',$this->site_oauth);
		$criteria->compare('t.site_type',$this->site_type);
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
		if($this->event_startdate != null && !in_array($this->event_startdate, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.event_startdate)',date('Y-m-d', strtotime($this->event_startdate)));
		if($this->event_finishdate != null && !in_array($this->event_finishdate, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.event_finishdate)',date('Y-m-d', strtotime($this->event_finishdate)));
		$criteria->compare('t.event_tag',$this->event_tag);
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
		$criteria->compare('t.analytic_profile_id',$this->analytic_profile_id,true);
		$criteria->compare('t.license_email',$this->license_email,true);
		$criteria->compare('t.license_key',$this->license_key,true);
		$criteria->compare('t.ommu_version',$this->ommu_version,true);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id',$this->modified_id);
		
		if(!isset($_GET['OmmuSettings_sort']))
			$criteria->order = 't.id DESC';
		
		// Custom Search
		$criteria->with = array(
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname'
			),
		);
		$criteria->compare('modified.displayname',strtolower($this->modified_search), true);

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
			$this->defaultColumns[] = 'site_oauth';
			$this->defaultColumns[] = 'site_type';
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
			$this->defaultColumns[] = 'event_startdate';
			$this->defaultColumns[] = 'event_finishdate';
			$this->defaultColumns[] = 'event_tag';
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
			$this->defaultColumns[] = 'analytic_profile_id';
			$this->defaultColumns[] = 'license_email';
			$this->defaultColumns[] = 'license_key';
			$this->defaultColumns[] = 'ommu_version';
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
			$this->defaultColumns[] = 'id';
			$this->defaultColumns[] = 'online';
			$this->defaultColumns[] = 'site_oauth';
			$this->defaultColumns[] = 'site_type';
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
			$this->defaultColumns[] = 'event_startdate';
			$this->defaultColumns[] = 'event_finishdate';
			$this->defaultColumns[] = 'event_tag';
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
			$this->defaultColumns[] = 'analytic_profile_id';
			$this->defaultColumns[] = 'license_email';
			$this->defaultColumns[] = 'license_key';
			$this->defaultColumns[] = 'ommu_version';
			$this->defaultColumns[] = 'modified_date';
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
			$action = strtolower(Yii::app()->controller->action->id);
			$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
			if($this->online == 0) {
				if($this->construction_date == '') {
					$this->addError('construction_date', Yii::t('phrase', 'Maintenance date cannot be blank.'));
				}
				if($this->construction_text == '') {
					$this->addError('construction_text', Yii::t('phrase', 'Maintenance text cannot be blank.'));
				}
			}
			
			if($currentAction == 'settings/general') {			
				if(in_array(date('Y-m-d', strtotime($this->event_startdate)), array('0000-00-00','1970-01-01')) && in_array(date('Y-m-d', strtotime($this->event_finishdate)), array('0000-00-00','1970-01-01')))
					$this->event = 0;
			
				if($this->event == 0) {
					$this->event_startdate = '00-00-0000';	
					$this->event_finishdate = '00-00-0000';	
				}
			
				if($this->event != 0 && ($this->event_startdate != '' && $this->event_finishdate != '') && (date('Y-m-d', strtotime($this->event_startdate)) >= date('Y-m-d', strtotime($this->event_finishdate))))
					$this->addError('event_finishdate', Yii::t('phrase', 'Event Finishdate tidak boleh lebih kecil'));
			}
			
			$this->modified_id = Yii::app()->user->id;
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$this->construction_date = date('Y-m-d', strtotime($this->construction_date));
			$this->event_startdate = date('Y-m-d', strtotime($this->event_startdate));
			$this->event_finishdate = date('Y-m-d', strtotime($this->event_finishdate));
		}
		return true;
	}

}