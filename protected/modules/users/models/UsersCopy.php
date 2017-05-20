<?php
/**
 * Users
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
 * This is the model class for table "ommu_users".
 *
 * The followings are the available columns in table 'ommu_users':
 * @property string $user_id
 * @property integer $level_id
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
 * @property string $creation_date
 * @property string $creation_ip
 * @property string $modified_date
 * @property string $modified_id
 * @property string $lastlogin_date
 * @property string $lastlogin_ip
 * @property string $lastlogin_from
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
class UsersCopy extends CActiveRecord
{
	public $defaultColumns = array();

	public $oldPassword;
	public $newPassword;
	public $confirmPassword;
	public $inviteCode;
	public $referenceId;

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
			array('level_id, email, first_name, last_name', 'required'),
			array('displayname', 'required', 'on'=>'formEdit'),
			array('
				oldPassword', 'required', 'on'=>'formChangePassword'),
			array('
				newPassword, confirmPassword', 'required', 'on'=>'formAdd, formChangePassword, resetpassword'),
			array('level_id, language_id, photo_id, enabled, verified, deactivate, search, invisible, show_profile, privacy, comments, locale_id, timezone_id', 'numerical', 'integerOnly'=>true),
			array('photo_id, status_id, modified_id', 'length', 'max'=>11),
			array('
				inviteCode', 'length', 'max'=>16),
			array('creation_ip, lastlogin_ip, update_ip', 'length', 'max'=>20),
			array('email, salt, password, first_name, last_name, username,
				oldPassword, newPassword, confirmPassword', 'length', 'max'=>32),
			array('displayname', 'length', 'max'=>64),
			//array('email', 'email'),
			array('email, username', 'unique'),
			array('username', 'match', 'pattern' => '/^[a-zA-Z0-9_.-]{0,25}$/', 'message' => Yii::t('other', 'Nama user hanya boleh berisi karakter, angka dan karakter (., -, _)')),
			array('level_id, password, username, enabled, verified, deactivate, invisible, lastlogin_from,
				oldPassword, newPassword, confirmPassword, inviteCode, referenceId', 'safe'),
			array('
				newPassword', 'compare', 'compareAttribute' => 'confirmPassword', 'message' => 'Kedua password tidak sama2.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, level_id, language_id, email, salt, password, first_name, last_name, displayname, photo_id, status_id, username, enabled, verified, deactivate, search, invisible, show_profile, privacy, comments, creation_date, creation_ip, modified_date, modified_id, lastlogin_date, lastlogin_ip, lastlogin_from, update_date, update_ip, locale_id, timezone_id', 'safe', 'on'=>'search'),
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
			'level_relation' => array(self::BELONGS_TO, 'UserLevel', 'level_id'),
			'photo' => array(self::BELONGS_TO, 'UserPhoto', 'photo_id'),
			'option' => array(self::BELONGS_TO, 'UserOption', 'user_id'),
			'view_user' => array(self::BELONGS_TO, 'ViewUsers', 'user_id'),
			'view' => array(self::BELONGS_TO, 'ViewUserLevel', 'level_id'),
			'photos' => array(self::HAS_MANY, 'UserPhoto', 'user_id', 'on'=>'photos.publish=1'),
			'photo_all' => array(self::HAS_MANY, 'UserPhoto', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => Yii::t('attribute', 'User'),
			'level_id' => Yii::t('attribute', 'User Level'),
			'language_id' => Yii::t('attribute', 'Language'),
			'email' => Yii::t('attribute', 'Email'),
			'salt' => Yii::t('attribute', 'Salt'),
			'password' => Yii::t('attribute', 'Password'),
			'first_name' => Yii::t('attribute', 'First Name'),
			'last_name' => Yii::t('attribute', 'Last Name'),
			'displayname' => Yii::t('attribute', 'Displayname'),
			'photo_id' => Yii::t('attribute', 'Photo'),
			'status_id' => Yii::t('attribute', 'Status'),
			'username' => Yii::t('attribute', 'Username'),
			'enabled' => Yii::t('attribute', 'Enabled'),
			'verified' => Yii::t('attribute', 'Verified'),
			'deactivate' => Yii::t('attribute', 'Deactivate'),
			'search' => Yii::t('attribute', 'Search'),
			'invisible' => Yii::t('attribute', 'Invisible'),
			'show_profile' => Yii::t('attribute', 'Show Profile'),
			'privacy' => Yii::t('attribute', 'Privacy'),
			'comments' => Yii::t('attribute', 'Comments'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_ip' => Yii::t('attribute', 'Creation Ip'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'lastlogin_date' => Yii::t('attribute', 'Lastlogin Date'),
			'lastlogin_ip' => Yii::t('attribute', 'Lastlogin Ip'),
			'lastlogin_from' => 'Last Login From',
			'update_date' => Yii::t('attribute', 'Update Date'),
			'update_ip' => Yii::t('attribute', 'Update Ip'),
			'locale_id' => Yii::t('attribute', 'Locale'),
			'timezone_id' => Yii::t('attribute', 'Timezone'),
			'oldPassword' => Yii::t('attribute', 'Password'),
			'newPassword' => Yii::t('attribute', 'New Password'),
			'confirmPassword' => Yii::t('attribute', 'Confirm Password'),
			'inviteCode' => Yii::t('attribute', 'Invite Code'),
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
		if($controller == 'o/member') {
			$criteria->addNotInCondition('t.level_id',array(1));
			$criteria->compare('t.level_id',$this->level_id);
		} else if($controller == 'o/admin') {
			$criteria->compare('t.level_id',1);
		}
		$criteria->addNotInCondition('t.user_id',array(1,2,3,4));
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
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_ip',$this->creation_ip,true);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id',$this->modified_id,true);
		if($this->lastlogin_date != null && !in_array($this->lastlogin_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.lastlogin_date)',date('Y-m-d', strtotime($this->lastlogin_date)));
		$criteria->compare('t.lastlogin_ip',$this->lastlogin_ip,true);
		$criteria->compare('t.lastlogin_from',$this->lastlogin_from,true);
		if($this->update_date != null && !in_array($this->update_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.update_date)',date('Y-m-d', strtotime($this->update_date)));
		$criteria->compare('t.update_ip',$this->update_ip,true);
		$criteria->compare('t.locale_id',$this->locale_id);
		$criteria->compare('t.timezone_id',$this->timezone_id);

		if(!isset($_GET['Users_sort']))
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
		}else {
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'level_id';
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
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_ip';
			$this->defaultColumns[] = 'modified_date';
			$this->defaultColumns[] = 'modified_id';
			$this->defaultColumns[] = 'lastlogin_date';
			$this->defaultColumns[] = 'lastlogin_ip';
			$this->defaultColumns[] = 'lastlogin_from';
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
			if(!in_array($controller, array('o/admin'))) {
				$this->defaultColumns[] = array(
					'name' => 'level_id',
					'value' => 'Phrase::trans($data->level_relation->name,2)',
					'htmlOptions' => array(
						//'class' => 'center',
					),
					'filter'=>UserLevel::getUserLevel(),
					'type' => 'raw',
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Utility::dateFormat($data->creation_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.components.system.CJuiDatePicker', array(
					'model'=>$this, 
					'attribute'=>'creation_date', 
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
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
			if($controller != 'o/admin') {
				$this->defaultColumns[] = array(
					'name' => 'verified',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("verify",array("id"=>$data->user_id)), $data->verified, 7)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Yii::t('phrase', 'Yes'),
						0=>Yii::t('phrase', 'No'),
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
					1=>Yii::t('phrase', 'Yes'),
					0=>Yii::t('phrase', 'No'),
				),
				'type' => 'raw',
			);
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
		$password = '' ;

		while ($i <= 4) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 2);
			$password = $password . $tmp; 
			$i++;
		}

		return $password;
	}

	/**
	 * User Salt
	 */
	public static function hashPassword($salt, $password)
	{
		return md5($salt.$password);
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() 
	{
		$controller = strtolower(Yii::app()->controller->id);
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		$setting = OmmuSettings::model()->findByPk(1, array(
			'select' => 'site_type, signup_username, signup_approve, signup_verifyemail, signup_random, signup_inviteonly, signup_checkemail',
		));

		if(parent::beforeValidate()) {
			if($this->isNewRecord) {

				/**
				 * Default action
				 * = Default register member
				 * = Random password
				 * = Username required
				 */
				$this->salt = self::getUniqueCode();
				
				if(in_array($controller, array('o/admin','o/member'))) {
					// Auto Approve Users
					if($setting->signup_approve == 1)
						$this->enabled = 1;
				
					// Auto Verified Email User
					if($setting->signup_verifyemail == 1)
						$this->verified = 0;
				
					// Generate user by admin
					$this->modified_id = !Yii::app()->user->isGuest ? Yii::app()->user->id : 0;
					
				} else {
					$this->level_id = UserLevel::getDefault();
					$this->enabled = $setting->signup_approve == 1 ? 1 : 0;
					$this->verified = $setting->signup_verifyemail == 1 ? 0 : 1;

					// Signup by Invite (Admin or User)
					if($setting->site_type == 1 && $setting->signup_inviteonly != 0) {
						if($setting->signup_checkemail == 1 && $this->inviteCode == '')
							$this->addError('inviteCode', 'Invite Code tidak boleh kosong.');
						
						if($this->email != '') {
							$invite = UserInvites::getInvite(strtolower($this->email));
							
							if($invite != null) {
								if($invite->queue->member_id != 0)
									$this->addError('email', 'Email anda sudah terdaftar sebagai user, silahkan login.');
									
								else {
									if($setting->signup_inviteonly == 1 && $invite->queue->invite == 0)
										$this->addError('email', 'Maaf invite hanya bisa dilakukan oleh admin');
									
									else {
										if($setting->signup_checkemail == 1) {
											$code = UserInvites::model()->findByAttributes(array('code' => $this->inviteCode), array(
												'select' => 'queue_id, user_id, code',
											));
											if($code == null)
												$this->addError('inviteCode', 'Invite Code yang and masukan salah.');
											else
												$this->referenceId = $code->user_id;
										}
									}
								}
							} else
								$this->addError('email', 'Email anda belum ada dalam daftar invite.');
							
						} else {
							if($setting->signup_checkemail == 1)
								$this->addError('inviteCode', 'Invite Code yang and masukan salah, silahkan lengkapi input email');
						}
					}
				}

				// Username required
				if($setting->signup_username == 1) {
					if($this->username != '') {
						$user = self::model()->findByAttributes(array('username' => $this->username));
						if($user != null) {
							$this->addError('username', 'Username already in use');
						}
					} else {
						$this->addError('username', 'Username cannot be blank.');
					}
				}

				// Random password
				if($setting->signup_random == 1) {
					$this->confirmPassword = $this->newPassword = self::getGeneratePassword();
					$this->verified = 1;
				}
				
				$this->creation_ip = $_SERVER['REMOTE_ADDR'];

			} else {
				/**
				 * Modify Mamber
				 * = Admin modify member
				 * = User modify
				 */
				
				// Admin modify member
				if(in_array($currentAction, array('o/admin/edit','o/member/edit'))) {
					$this->modified_date = date('Y-m-d H:i:s');
					$this->modified_id = Yii::app()->user->id;
				
				// User modify
				} else {
					// Admin change password
					if(in_array($currentAction, array('o/admin/password'))) {
						if($this->oldPassword != '') {
							$user = self::model()->findByPk(Yii::app()->user->id, array(
								'select' => 'user_id, salt, password',
							));
							if($user->password !== self::hashPassword($user->salt, $this->oldPassword)) {
								$this->addError('oldPassword', 'Old password is incorrect.');
							}
						}
					}
					if($controller != 'forgot')
						$this->update_date = date('Y-m-d H:i:s');
					$this->update_ip = $_SERVER['REMOTE_ADDR'];
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
			$this->email = strtolower($this->email);
			$this->username = strtolower($this->username);
			if($this->newPassword != '')
				$this->password = self::hashPassword($this->salt, $this->newPassword);
		}
		return true;	
	}
	
	/**
	 * After save attributes
	 */
	protected function afterSave() 
	{
		$controller = strtolower(Yii::app()->controller->id);
		$setting = OmmuSettings::model()->findByPk(1, array(
			'select' => 'site_type, signup_welcome, signup_adminemail',
		));
		$_assetsUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('users.assets'));
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
			if(!file_exists($user_path)) {
				mkdir($user_path, 0755, true);

				// Add File in User Folder (index.php)
				$newFile = $user_path.'/index.php';
				$FileHandle = fopen($newFile, 'w');
			} else
				@chmod($user_path, 0755, true);

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
			if($setting->site_type == 1) {
				$invite = UserInviteQueue::model()->findByAttributes(array('email' => strtolower($this->email)), array(
					'select' => 'queue_id, member_id, reference_id',
				));
				if($invite != null && $invite->member_id == 0) {
					$invite->member_id = $this->user_id;
					if($this->referenceId != '')
						$invite->reference_id = $this->referenceId;
					$invite->update();
				}
			}
			
			// this user ommu (administrator)
			$ommuStatus = $this->level_id == 1 ? 1 : 0;
			UserOption::model()->updateByPk($this->user_id, array(
				'ommu_status'=>$ommuStatus,
				'signup_from'=>Yii::app()->params['product_access_system'],
			));
				
			// Send Welcome Email
			if($setting->signup_welcome == 1) {
				$welcome_search = array(
					'{$baseURL}',
					'{$index}','{$displayname}',
				);
				$welcome_replace = array(
					Utility::getProtocol().'://'.Yii::app()->request->serverName.$_assetsUrl,
					Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->createUrl('site/index'),
					$this->displayname,	
				);
				$welcome_template = 'user_welcome';
				$welcome_title = 'Welcome to SSO-GTP by BPAD Yogyakarta';
				$welcome_message = file_get_contents(YiiBase::getPathOfAlias('application.modules.users.components.templates').'/'.$welcome_template.'.php');
				$welcome_ireplace = str_ireplace($welcome_search, $welcome_replace, $welcome_message);
				SupportMailSetting::sendEmail($this->email, $this->displayname, $welcome_title, $welcome_ireplace);		
			}

			// Send Account Information
			//if($this->enabled == 1)
			$account_search = array(
				'{$baseURL}',
				'{$login}','{$displayname}','{$email}','{$password}',
			);
			$account_replace = array(
				Utility::getProtocol().'://'.Yii::app()->request->serverName.$_assetsUrl,
				Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->createUrl('site/login'),
				$this->displayname, $this->email, $this->newPassword,
			);
			$account_template = 'user_welcome_account';
			$account_title = 'SSO-GTP Account ('.$this->displayname.')';
			$account_message = file_get_contents(YiiBase::getPathOfAlias('application.modules.users.components.templates').'/'.$account_template.'.php');
			$account_ireplace = str_ireplace($account_search, $account_replace, $account_message);
			SupportMailSetting::sendEmail($this->email, $this->displayname, $account_title, $account_ireplace);

			// Send New Account to Email Administrator
			if($setting->signup_adminemail == 1)
				SupportMailSetting::sendEmail($this->email, $this->displayname, 'New Member', 'informasi member terbaru', 0);
			
		} else {
			// Send Account Information
			//if($this->enabled == 1) {}
			if($controller == 'password') {
				$account_search = array(
					'{$baseURL}',
					'{$login}','{$displayname}','{$email}','{$password}',
				);
				$account_replace = array(
					Utility::getProtocol().'://'.Yii::app()->request->serverName.$_assetsUrl,
					Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->createUrl('site/login'),
					$this->displayname, $this->email, $this->newPassword,
				);
				$account_template = 'user_forgot_new_password';
				$account_title = 'Your password changed';
				$account_message = file_get_contents(YiiBase::getPathOfAlias('application.modules.users.components.templates').'/'.$account_template.'.php');
				$account_ireplace = str_ireplace($account_search, $account_replace, $account_message);
				SupportMailSetting::sendEmail($this->email, $this->displayname, $account_title, $account_ireplace);
			}

			if($controller == 'verify')
				SupportMailSetting::sendEmail($this->email, $this->displayname, 'Verify Email Success', 'Verify Email Success');
		}
	}

	/**
	 * Before delete attributes
	 */
	protected function beforeDelete() {
		if(parent::beforeDelete()) {			
			//delete user photo_all
			$photo_all = $this->photo_all;
			if(!empty($photo_all)) {
				foreach($photo_all as $val) {
					$user_path = 'public/users/'.$val->user_id;
					if($val->photo != '' && file_exists($user_path.'/'.$val->photo))
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