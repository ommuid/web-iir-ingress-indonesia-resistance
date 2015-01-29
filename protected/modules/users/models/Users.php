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
 * This is the model class for table "ommu_users".
 *
 * The followings are the available columns in table 'ommu_users':
 * @property string $user_id
 * @property integer $level_id
 * @property integer $profile_id
 * @property integer $language_id
 * @property string $email
 * @property string $salt
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $displayname
 * @property string $photo_id
 * @property string $status_id
 * @property string $username
 * @property integer $enabled
 * @property integer $verified
 * @property integer $deactivate
 * @property integer $search
 * @property integer $invisible
 * @property integer $show_profile
 * @property integer $privacy
 * @property integer $comments
 * @property string $last_email
 * @property string $creation_date
 * @property string $creation_ip
 * @property string $modified_date
 * @property string $modified_id
 * @property string $lastlogin_date
 * @property string $lastlogin_ip
 * @property string $update_date
 * @property string $update_ip
 * @property integer $locale_id
 * @property integer $timezone_id
 *
 * The followings are the available model relations:
 * @property OmmuUserBlock[] $ommuUserBlocks
 * @property OmmuUserContact[] $ommuUserContacts
 * @property OmmuUserForgot[] $ommuUserForgots
 * @property OmmuUserStatus[] $ommuUserStatuses
 * @property OmmuUserVerify[] $ommuUserVerifies
 */
class Users extends CActiveRecord
{
	public $defaultColumns = array();

	public $old_password;
	public $new_password;
	public $confirm_password;
	public $invite_code;
	public $reference_id;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
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
		return 'ommu_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profile_id, email, first_name, last_name', 'required', 'on'=>'adminadd, adminedit, signup'),
			array('displayname', 'required', 'on'=>'adminedit'),
			array('
				old_password', 'required', 'on'=>'adminpassword, signup'),
			array('
				new_password', 'required', 'on'=>'adminadd, adminpassword, resetpassword'),
			array('
				confirm_password', 'required', 'on'=>'adminadd, adminpassword, resetpassword, signup'),
			array('level_id, profile_id, language_id, photo_id, enabled, verified, deactivate, search, invisible, show_profile, privacy, comments, locale_id, timezone_id', 'numerical', 'integerOnly'=>true),
			array('photo_id, status_id, modified_id', 'length', 'max'=>11),
			array('
				invite_code', 'length', 'max'=>16),
			array('creation_ip, lastlogin_ip, update_ip', 'length', 'max'=>20),
			array('email, salt, password, first_name, last_name, username, last_email, 
				old_password, new_password, confirm_password', 'length', 'max'=>32),
			array('displayname', 'length', 'max'=>64),
			array('email', 'email'),
			array('email', 'unique'),
			array('username', 'match', 'pattern' => '/^[a-zA-Z0-9_.-]{0,25}$/', 'message' => Yii::t('other', 'Nama user hanya boleh berisi karakter, angka dan karakter (., -, _)')),
			array('level_id, password, username, enabled, verified, deactivate, invisible,
				old_password, new_password, confirm_password, invite_code, reference_id', 'safe'),
			array('
				old_password', 'compare', 'compareAttribute' => 'confirm_password', 'message' => 'Kedua password tidak sama1.', 'on'=>'signup'),
			array('
				new_password', 'compare', 'compareAttribute' => 'confirm_password', 'message' => 'Kedua password tidak sama2.', 'on'=>'adminadd, adminedit, adminpassword, resetpassword'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, level_id, profile_id, language_id, email, salt, password, first_name, last_name, displayname, photo_id, status_id, username, enabled, verified, deactivate, search, invisible, show_profile, privacy, comments, last_email, creation_date, creation_ip, modified_date, modified_id, lastlogin_date, lastlogin_ip, update_date, update_ip, locale_id, timezone_id', 'safe', 'on'=>'search'),
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
			'level' => array(self::BELONGS_TO, 'UserLevel', 'level_id'),
			'photo' => array(self::BELONGS_TO, 'UserPhoto', 'photo_id'),
			'option' => array(self::BELONGS_TO, 'UserOption', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => Phrase::trans(16001,1),
			'level_id' => Phrase::trans(16106,1),
			'profile_id' => Phrase::trans(16149,1),
			'language_id' => Phrase::trans(16115,1),
			'email' => Phrase::trans(16108,1),
			'salt' => Phrase::trans(16150,1),
			'password' => Phrase::trans(16112,1),
			'first_name' => Phrase::trans(16113,1),
			'last_name' => Phrase::trans(16114,1),
			'displayname' => Phrase::trans(16107,1),
			'photo_id' => Phrase::trans(16151,1),
			'status_id' => Phrase::trans(16152,1),
			'username' => Phrase::trans(16116,1),
			'enabled' => Phrase::trans(16117,1),
			'verified' => Phrase::trans(16118,1),
			'deactivate' => Phrase::trans(16119,1),
			'search' => Phrase::trans(16153,1),
			'invisible' => Phrase::trans(16154,1),
			'show_profile' => Phrase::trans(16155,1),
			'privacy' => Phrase::trans(16156,1),
			'comments' => Phrase::trans(16157,1),
			'last_email' => Phrase::trans(16158,1),
			'creation_date' => Phrase::trans(16160,1),
			'creation_ip' => Phrase::trans(16161,1),
			'modified_date' => Phrase::trans(16162,1),
			'modified_id' => Phrase::trans(16163,1),
			'lastlogin_date' => Phrase::trans(16164,1),
			'lastlogin_ip' => Phrase::trans(16165,1),
			'update_date' => Phrase::trans(16166,1),
			'update_ip' => Phrase::trans(16167,1),
			'locale_id' => Phrase::trans(16168,1),
			'timezone_id' => Phrase::trans(16169,1),
			'old_password' => Phrase::trans(16112,1),
			'new_password' => Phrase::trans(16110,1),
			'confirm_password' => Phrase::trans(16111,1),
			'invite_code' => Phrase::trans(16211,1),
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
		$controller = strtolower(Yii::app()->controller->id);

		$criteria=new CDbCriteria;

		$criteria->compare('t.user_id',$this->user_id,true);
		if($controller == 'member') {
			$criteria->addNotInCondition('level_id',array(1));
			$criteria->compare('t.level_id',$this->level_id);
		} else if($controller == 'admin') {
			$criteria->compare('t.level_id',1);
		}
		$criteria->compare('t.profile_id',$this->profile_id);
		$criteria->compare('t.language_id',$this->language_id);
		$criteria->compare('t.email',strtolower($this->email),true);
		$criteria->compare('t.salt',$this->salt,true);
		$criteria->compare('t.password',$this->password,true);
		$criteria->compare('t.first_name',strtolower($this->first_name),true);
		$criteria->compare('t.last_name',strtolower($this->last_name),true);
		$criteria->compare('t.displayname',strtolower($this->displayname),true);
		$criteria->compare('t.photo_id',$this->photo_id,true);
		$criteria->compare('t.status_id',$this->status_id,true);
		$criteria->compare('t.username',strtolower($this->username),true);
		$criteria->compare('t.enabled',$this->enabled);
		$criteria->compare('t.verified',$this->verified);
		$criteria->compare('t.deactivate',$this->deactivate);
		$criteria->compare('t.search',$this->search);
		$criteria->compare('t.invisible',$this->invisible);
		$criteria->compare('t.show_profile',$this->show_profile);
		$criteria->compare('t.privacy',$this->privacy);
		$criteria->compare('t.comments',$this->comments);
		$criteria->compare('t.last_email',strtolower($this->last_email),true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_ip',$this->creation_ip,true);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id',$this->modified_id,true);
		if($this->lastlogin_date != null && !in_array($this->lastlogin_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.lastlogin_date)',date('Y-m-d', strtotime($this->lastlogin_date)));
		$criteria->compare('t.lastlogin_ip',$this->lastlogin_ip,true);
		if($this->update_date != null && !in_array($this->update_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.update_date)',date('Y-m-d', strtotime($this->update_date)));
		$criteria->compare('t.update_ip',$this->update_ip,true);
		$criteria->compare('t.locale_id',$this->locale_id);
		$criteria->compare('t.timezone_id',$this->timezone_id);

		if(!isset($_GET['Users_sort']))
			$criteria->order = 'user_id DESC';

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
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'level_id';
			$this->defaultColumns[] = 'profile_id';
			$this->defaultColumns[] = 'language_id';
			$this->defaultColumns[] = 'email';
			$this->defaultColumns[] = 'salt';
			$this->defaultColumns[] = 'password';
			$this->defaultColumns[] = 'first_name';
			$this->defaultColumns[] = 'last_name';
			$this->defaultColumns[] = 'displayname';
			$this->defaultColumns[] = 'photo_id';
			$this->defaultColumns[] = 'status_id';
			$this->defaultColumns[] = 'username';
			$this->defaultColumns[] = 'enabled';
			$this->defaultColumns[] = 'verified';
			$this->defaultColumns[] = 'deactivate';
			$this->defaultColumns[] = 'search';
			$this->defaultColumns[] = 'invisible';
			$this->defaultColumns[] = 'show_profile';
			$this->defaultColumns[] = 'privacy';
			$this->defaultColumns[] = 'comments';
			$this->defaultColumns[] = 'last_email';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_ip';
			$this->defaultColumns[] = 'modified_date';
			$this->defaultColumns[] = 'modified_id';
			$this->defaultColumns[] = 'lastlogin_date';
			$this->defaultColumns[] = 'lastlogin_ip';
			$this->defaultColumns[] = 'update_date';
			$this->defaultColumns[] = 'update_ip';
			$this->defaultColumns[] = 'locale_id';
			$this->defaultColumns[] = 'timezone_id';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			$controller = strtolower(Yii::app()->controller->id);
			/*
			$this->defaultColumns[] = array(
				'class' => 'CCheckBoxColumn',
				'name' => 'id',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'trash_id[]')
			);
			$this->defaultColumns[] = array(
				'name' => 'user_id',
				'value' => '$data->user_id',
				'htmlOptions' => array(
					'class' => 'center',
				),
			);
			*/
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			$this->defaultColumns[] = 'displayname';
			$this->defaultColumns[] = 'email';
			if(!in_array($controller, array('admin'))) {
				$this->defaultColumns[] = array(
					'name' => 'level_id',
					'value' => 'Phrase::trans($data->level->name,2)',
					'htmlOptions' => array(
						//'class' => 'center',
					),
					'filter'=>UserLevel::getTypeMember(),
					'type' => 'raw',
				);
			}
			if($controller != 'admin') {
				$this->defaultColumns[] = array(
					'name' => 'verified',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("verify",array("id"=>$data->user_id)), $data->verified, 7)',
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
			$this->defaultColumns[] = array(
				'name' => 'enabled',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("enabled",array("id"=>$data->user_id)), $data->enabled, 3)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>Phrase::trans(588,0),
					0=>Phrase::trans(589,0),
				),
				'type' => 'raw',
			);
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
		}
		parent::afterConstruct();
	}

	/**
	 * User salt codes
	 */
	public static function getUniqueCode() {
		$chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		srand((double)microtime()*1000000);
		$i = 0;
		$salt = '' ;

		while ($i <= 15) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 2);
			$salt = $salt . $tmp; 
			$i++;
		}

		return $salt;
	}

	/**
	 * User generate password
	 */
	public static function getGeneratePassword() {
		$chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		srand((double)microtime()*1000000);
		$i = 0;
		$salt = '' ;

		while ($i <= 4) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 2);
			$salt = $salt . $tmp; 
			$i++;
		}

		return $salt;
	}

	/**
	 * User Salt
	 */
	public static function hashPassword($salt, $password)
	{
		return md5($salt.$password);
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column)
	{
		$model = self::model()->findByPk($id,array(
			'select' => $column
		));
		return $model->$column;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() 
	{
		$controller = strtolower(Yii::app()->controller->id);
		$current = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);

		if(parent::beforeValidate()) {		
			if($this->isNewRecord) {

				$setting = OmmuSettings::model()->findByPk(1, array(
					'select' => 'signup_username, signup_approve, signup_verifyemail, signup_random, signup_inviteonly, signup_checkemail',
				));

				/**
				 * Default action
				 * = Default register member
				 * = Random password
				 * = Username required
				 */

				// Default register member
				if($controller == 'signup') {
					$this->level_id = UserLevel::getDefault();
					$this->enabled = $setting->signup_approve == 1 ? 1 : 0;
					
					if($this->first_name == '' || $this->last_name =='')
						$this->addError('first_name', Phrase::trans(16224,1));						

					// Signup by Invite (Admin or User)
					if($setting->signup_inviteonly != 0) {
						if($setting->signup_checkemail == 1 && $this->invite_code == '') {
							$this->addError('invite_code', Phrase::trans(16199,1));
						}
						if($this->email != '') {
							$invite = UserInvites::getInvite($this->email);
							
							if($invite != null) {
								if($invite->queue->member_id != 0) {
									$this->addError('email', Phrase::trans(16200,1));
								} else {
									if($setting->signup_inviteonly == 1 && $invite->queue->invite == 0) {
										$this->addError('email', Phrase::trans(16201,1));
									} else {
										if($setting->signup_checkemail == 1) {
											$code = UserInvites::model()->findByAttributes(array('code' => $this->invite_code), array(
												'select' => 'queue_id, user_id, code',
											));
											if($code == null) {
												$this->addError('invite_code', Phrase::trans(16202,1));
											} else {
												$this->reference_id = $code->user_id;
											}
										}
									}
								}
							} else {
								$this->addError('email', Phrase::trans(16203,1));
							}
						} else {
							if($setting->signup_checkemail == 1) {
								$this->addError('invite_code', Phrase::trans(16204,1));
							}							
						}
					}

				} else {
					$this->enabled = 1;
					$this->modified_id = !Yii::app()->user->isGuest ? Yii::app()->user->id : 0;
				}

				// Random password
				if($setting->signup_random == 1 && $controller != 'admin') {
					if($controller == 'signup') {
						$this->old_password = $this->confirm_password = self::getGeneratePassword();
					} else if($controller == 'member') {
						$this->new_password = $this->confirm_password = self::getGeneratePassword();
					}
					$this->verified = 1;
				} else {
					if($controller == 'signup') {
						$this->verified = $setting->signup_verifyemail == 1 ? 0 : 1;
					}
				}

				// Username required
				if($setting->signup_username == 1) {
					if($this->username != '') {
						$user = self::model()->findByAttributes(array('username' => $this->username));
						if($user != null) {
							$this->addError('username', Phrase::trans(16196,1));
						}
					} else {
						$this->addError('username', Phrase::trans(16197,1));
					}
				}
				$this->profile_id = 1;
				$this->salt = self::getUniqueCode();
				$this->creation_ip = $_SERVER['REMOTE_ADDR'];

			} else {
				/**
				 * Modify Mamber
				 * = Admin modify member
				 * = User modify
				 */
				
				// Admin modify member
				if(in_array($current, array('admin/edit','member/edit'))) {
					$this->modified_date = date('Y-m-d H:i:s');
					$this->modified_id = Yii::app()->user->id;
				
				// User modify
				} else {
					// Admin change password
					if(in_array($current, array('admin/password'))) {
						if($this->old_password != '') {
							$user = self::model()->findByPk(Yii::app()->user->id, array(
								'select' => 'user_id, salt, password',
							));
							if($user->password !== self::hashPassword($user->salt, $this->old_password)) {
								$this->addError('old_password', Phrase::trans(16120,1));
							}
						}
					}
					if($controller != 'forgot') {
						$this->update_date = date('Y-m-d H:i:s');
					}
					$this->update_ip = $_SERVER['REMOTE_ADDR'];
				}
			}
		}
		return true;
	}
	
	protected function afterValidate()
	{
		$controller = strtolower(Yii::app()->controller->id);
		parent::afterValidate();
		if($controller == 'signup') {
			if(($this->old_password != '') && ($this->old_password == $this->confirm_password)) {
				if(count($this->errors) == 0) {
					$this->password = self::hashPassword($this->salt, $this->old_password);
				}
			}
		} else {
			if(($this->new_password != '') && ($this->new_password == $this->confirm_password)) {
				if(count($this->errors) == 0) {
					$this->password = self::hashPassword($this->salt, $this->new_password);
				}
			}
		}
		return true;
	}
	
	/**
	 * After save attributes
	 */
	protected function afterSave() 
	{
		$controller = strtolower(Yii::app()->controller->id);
		parent::afterSave();

		// Generate Verification Code
		if ($this->verified == 0) {
			$verify = new UserVerify;
			$verify->user_id = $this->user_id;
			$verify->save();
		}

		if($this->isNewRecord) {
			// Add User Folder
			$user_path = "public/users/".$this->user_id;
			if ( !file_exists($user_path) ) {
				mkdir($user_path, 0777, true);

				// Add File in User Folder (index.php)
				$newFile = $user_path.'/index.php';
				$FileHandle = fopen($newFile, 'w');
			}

			/**
			 * = New Member
			 * Add Subscribe Newsletter
			 * Add User Options
			 * Send Welcome Email
			 * Send Account Information
			 * Send New Account to Email Administrator
			 *
			 * = Update Member
			 * Send New Account Information
			 * Send Account Information
			 *
			 */
			$setting = OmmuSettings::model()->findByPk(1, array(
				'select' => 'site_type, signup_welcome, signup_random, signup_checkemail, signup_numgiven, signup_adminemail',
			));

			//if ($setting->site_type == 1 || ($setting->site_type == 0 && $this->level_id != 1)) {
				// Cek Invite
				$invite = UserInviteQueue::model()->findByAttributes(array('email' => $this->email), array(
					//'select' => 'queue_id, member_id, reference_id, email',
				));
				if($invite != null && $invite->member_id == 0) {
					$invite->member_id = $this->user_id;
					$invite->reference_id = $setting->signup_checkemail == 1 ? $this->reference_id : UserInvites::getInvite($this->email)->user_id;
					$invite->update();
				}
			//}

			if($this->level_id == 1) {
				$option = UserOption::model()->findByAttributes(array('user_id' => $this->user_id), array(
					'select' => 'id, user_id, ommu_status',
				));
				$option->ommu_status = 1;
				$option->update();
			}
				
			// Send Welcome Email
			if($setting->signup_welcome == 1) {
				SupportMailSetting::sendEmail($this->email, $this->displayname, 'Welcome', 'Selamat bergabung dengan Nirwasita Hijab and Dress Corner', 1);
			}

			// Send Account Information
			if($this->enabled == 1) {
				SupportMailSetting::sendEmail($this->email, $this->displayname, 'Account Information', 'your account information', 1);
			}

			// Send New Account to Email Administrator
			if($setting->signup_adminemail == 1) {
				SupportMailSetting::sendEmail($this->email, $this->displayname, 'New Member', 'informasi member terbaru', 0);
			}
			
		} else {
			// Send Account Information
			if($this->enabled == 1) {			
				if($controller == 'forgot') {
					SupportMailSetting::sendEmail($this->email, $this->displayname, 'New Account Information', 'this new your account information', 1);

				} else if($controller == 'verify') {
					SupportMailSetting::sendEmail($this->email, $this->displayname, 'Verify Email Success', 'Verify Email Success', 1);
				}
			}
		}
	}

	/**
	 * Before delete attributes
	 */
	protected function beforeDelete() {
		if(parent::beforeDelete()) {
			$user_photo = UserPhoto::getPhoto($this->user_id);
			$user_path = "public/users/".$this->user_id;
			foreach($user_photo as $val) {
				if($val->photo != '') {
					rename($user_path.'/'.$val->photo, 'public/users/verwijderen/'.$val->user_id.'_'.$val->photo);
				}
			}
		}
		return true;			
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() {
		parent::afterDelete();
		//delete user image
		$user_path = "public/users/".$this->user_id;
		Utility::deleteFolder($user_path);		
	}

}