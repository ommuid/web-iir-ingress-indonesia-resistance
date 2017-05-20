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
 * @property integer $enabled
 * @property integer $verified
 * @property integer $level_id
 * @property integer $language_id
 * @property integer $locale_id
 * @property integer $timezone_id
 * @property string $email
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $displayname
 * @property string $password
 * @property string $photos
 * @property string $salt
 * @property integer $deactivate
 * @property integer $search
 * @property integer $invisible
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
 *
 * The followings are the available model relations:
 * @property OmmuUserLevel $level
 */
class Users extends CActiveRecord
{
	public $defaultColumns = array();
	
	public $old_photos_i;
	public $oldPassword;
	public $newPassword;
	public $confirmPassword;
	public $invite_code_i;
	public $reference_id_i;
	
	// Variable Search
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
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
		preg_match("/dbname=([^;]+)/i", $this->dbConnection->connectionString, $matches);
		return $matches[1].'.ommu_users';
		//return 'ommu_users';
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
			array('enabled, verified, language_id, locale_id, timezone_id', 'required', 'on'=>'formEdit'),
			array('
				oldPassword', 'required', 'on'=>'formChangePassword'),
			array('
				newPassword, confirmPassword', 'required', 'on'=>'formAdd, formChangePassword, resetpassword'),
			array('enabled, verified, level_id, language_id, locale_id, timezone_id, deactivate, search, invisible, privacy, comments', 'numerical', 'integerOnly'=>true),
			array('modified_id', 'length', 'max'=>11),
			array('
				invite_code_i', 'length', 'max'=>16),
			array('creation_ip, lastlogin_ip, update_ip', 'length', 'max'=>20),
			array('email, username, first_name, last_name, password, salt, 
				oldPassword, newPassword, confirmPassword', 'length', 'max'=>32),
			array('enabled, verified, level_id, language_id, locale_id, timezone_id, username, displayname, password, photos, deactivate, invisible,
				old_photos_i, oldPassword, newPassword, confirmPassword, invite_code_i, reference_id_i', 'safe'),
			array('oldPassword', 'filter', 'filter'=>array($this,'validatePassword')),
			array('email', 'email'),
			array('email, username', 'unique'),
			array('username', 'match', 'pattern' => '/^[a-zA-Z0-9_.-]{0,25}$/', 'message' => Yii::t('phrase', 'Nama user hanya boleh berisi karakter, angka dan karakter (., -, _)')),
			array('
				newPassword', 'compare', 'compareAttribute' => 'confirmPassword', 'message' => 'Kedua password tidak sama.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, enabled, verified, level_id, language_id, locale_id, timezone_id, email, username, first_name, last_name, displayname, password, photos, salt, deactivate, search, invisible, privacy, comments, creation_date, creation_ip, modified_date, modified_id, lastlogin_date, lastlogin_ip, lastlogin_from, update_date, update_ip,
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
			'view' => array(self::BELONGS_TO, 'ViewUsers', 'user_id'),
			'option' => array(self::BELONGS_TO, 'UserOption', 'user_id'),
			'level' => array(self::BELONGS_TO, 'UserLevel', 'level_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => Yii::t('attribute', 'User'),
			'enabled' => Yii::t('attribute', 'Enabled'),
			'verified' => Yii::t('attribute', 'Verified'),
			'level_id' => Yii::t('attribute', 'Level'),
			'language_id' => Yii::t('attribute', 'Language'),
			'locale_id' => Yii::t('attribute', 'Locale'),
			'timezone_id' => Yii::t('attribute', 'Timezone'),
			'email' => Yii::t('attribute', 'Email'),
			'username' => Yii::t('attribute', 'Username'),
			'first_name' => Yii::t('attribute', 'First Name'),
			'last_name' => Yii::t('attribute', 'Last Name'),
			'displayname' => Yii::t('attribute', 'Displayname'),
			'password' => Yii::t('attribute', 'Password'),
			'photos' => Yii::t('attribute', 'Photos'),
			'salt' => Yii::t('attribute', 'Salt'),
			'deactivate' => Yii::t('attribute', 'Deactivate'),
			'search' => Yii::t('attribute', 'Search'),
			'invisible' => Yii::t('attribute', 'Invisible'),
			'privacy' => Yii::t('attribute', 'Privacy'),
			'comments' => Yii::t('attribute', 'Comments'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_ip' => Yii::t('attribute', 'Creation Ip'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'lastlogin_date' => Yii::t('attribute', 'Lastlogin Date'),
			'lastlogin_ip' => Yii::t('attribute', 'Lastlogin Ip'),
			'lastlogin_from' => Yii::t('attribute', 'Last Login From'),
			'update_date' => Yii::t('attribute', 'Update Date'),
			'update_ip' => Yii::t('attribute', 'Update Ip'),
			'old_photos_i' => Yii::t('attribute', 'Old Photo (File)'),
			'oldPassword' => Yii::t('attribute', 'Password'),
			'newPassword' => Yii::t('attribute', 'New Password'),
			'confirmPassword' => Yii::t('attribute', 'Confirm Password'),
			'invite_code_i' => Yii::t('attribute', 'Invite Code'),
			'modified_search' => Yii::t('attribute', 'Modified'),
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
		$controller = strtolower(Yii::app()->controller->id);

		$criteria=new CDbCriteria;
		
		// Custom Search
		$criteria->with = array(
			'view' => array(
				'alias'=>'view',
			),
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname',
			),
		);

		if($controller == 'o/admin')
			$criteria->addNotInCondition('t.user_id',array(1));
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.enabled',$this->enabled);
		$criteria->compare('t.verified',$this->verified);
		if(isset($_GET['level']))
			$criteria->compare('t.level_id',$_GET['level']);
		else {
			if($controller == 'o/member') {
				$criteria->addNotInCondition('t.level_id',array(1));
				$criteria->compare('t.level_id',$this->level_id);
			} else if($controller == 'o/admin')
				$criteria->compare('t.level_id',1);
			else
				$criteria->compare('t.level_id',$this->level_id);
		}
		$criteria->compare('t.language_id',$this->language_id);
		$criteria->compare('t.locale_id',$this->locale_id);
		$criteria->compare('t.timezone_id',$this->timezone_id);
		$criteria->compare('t.email',strtolower($this->email),true);
		$criteria->compare('t.username',strtolower($this->username),true);
		$criteria->compare('t.first_name',strtolower($this->first_name),true);
		$criteria->compare('t.last_name',strtolower($this->last_name),true);
		$criteria->compare('t.displayname',strtolower($this->displayname),true);
		$criteria->compare('t.password',strtolower($this->password),true);
		$criteria->compare('t.photos',strtolower($this->photos),true);
		$criteria->compare('t.salt',strtolower($this->salt),true);
		$criteria->compare('t.deactivate',$this->deactivate);
		$criteria->compare('t.search',$this->search);
		$criteria->compare('t.invisible',$this->invisible);
		$criteria->compare('t.privacy',$this->privacy);
		$criteria->compare('t.comments',$this->comments);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_ip',strtolower($this->creation_ip),true);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		if(isset($_GET['modified']))
			$criteria->compare('t.modified_id',$_GET['modified']);
		else
			$criteria->compare('t.modified_id',$this->modified_id);
		if($this->lastlogin_date != null && !in_array($this->lastlogin_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.lastlogin_date)',date('Y-m-d', strtotime($this->lastlogin_date)));
		$criteria->compare('t.lastlogin_ip',strtolower($this->lastlogin_ip),true);
		$criteria->compare('t.lastlogin_from',strtolower($this->lastlogin_from),true);
		if($this->update_date != null && !in_array($this->update_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.update_date)',date('Y-m-d', strtotime($this->update_date)));
		$criteria->compare('t.update_ip',strtolower($this->update_ip),true);
		
		$criteria->compare('modified.displayname',strtolower($this->modified_search), true);

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
		} else {
			//$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'enabled';
			$this->defaultColumns[] = 'verified';
			$this->defaultColumns[] = 'level_id';
			$this->defaultColumns[] = 'language_id';
			$this->defaultColumns[] = 'locale_id';
			$this->defaultColumns[] = 'timezone_id';
			$this->defaultColumns[] = 'email';
			$this->defaultColumns[] = 'username';
			$this->defaultColumns[] = 'first_name';
			$this->defaultColumns[] = 'last_name';
			$this->defaultColumns[] = 'displayname';
			$this->defaultColumns[] = 'password';
			$this->defaultColumns[] = 'photos';
			$this->defaultColumns[] = 'salt';
			$this->defaultColumns[] = 'deactivate';
			$this->defaultColumns[] = 'search';
			$this->defaultColumns[] = 'invisible';
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
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() 
	{
		$controller = strtolower(Yii::app()->controller->id);
		
		if(count($this->defaultColumns) == 0) {
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
			if(!in_array($controller, array('o/admin'))) {
				$this->defaultColumns[] = array(
					'name' => 'level_id',
					'value' => 'Phrase::trans($data->level->name)',
					'htmlOptions' => array(
						//'class' => 'center',
					),
					'filter'=>UserLevel::getUserLevel('member'),
					'type' => 'raw',
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'displayname',
				'value' => '$data->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'email',
				'value' => '$data->email',
			);
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
			$this->defaultColumns[] = array(
				'name' => 'creation_ip',
				'value' => '$data->creation_ip',
				'htmlOptions' => array(
					'class' => 'center',
				),
			);
			if(!in_array($controller, array('o/admin'))) {
				$this->defaultColumns[] = array(
					'name' => 'verified',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("verified",array("id"=>$data->user_id)), $data->verified, 1)',
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
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'enabled',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("enabled",array("id"=>$data->user_id)), $data->enabled, 1)',
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
	 * get Current Password
	 */
	public function validatePassword($password)
	{
		if($password != '') {
			$user = self::model()->findByPk($this->user_id, array(
				'select' => 'user_id, salt, password',
			));
			if($user->password !== self::hashPassword($user->salt, $password))
				$this->addError('oldPassword', 'Old password is incorrect.');
			else {
				if($this->newPassword == $this->confirmPassword && $this->newPassword == $password)
					$this->addError('newPassword', 'New Password tidak boleh sama dengan Password sebelumnya.');
			}
		}
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() 
	{
		$controller = strtolower(Yii::app()->controller->id);
		$action = strtolower(Yii::app()->controller->action->id);
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		$setting = OmmuSettings::model()->findByPk(1, array(
			'select' => 'site_oauth, site_type, signup_username, signup_approve, signup_verifyemail, signup_random, signup_inviteonly, signup_checkemail',
		));

		if(parent::beforeValidate()) {
			$photo_exts = unserialize($this->level->photo_exts);
			if(empty($photo_exts))
				$photo_exts = array();
			$photos = CUploadedFile::getInstance($this, 'photos');
			if($photos != null) {
				$extension = pathinfo($photos->name, PATHINFO_EXTENSION);
				if(!in_array(strtolower($extension), $photo_exts))
					$this->addError('photos', Yii::t('phrase', 'The file {name} cannot be uploaded. Only files with these extensions are allowed: {extensions}.', array(
						'{name}'=>$photos->name,
						'{extensions}'=>Utility::formatFileType($photo_exts, false),
					)));
					
			} else {
				if(!$this->isNewRecord && $currentAction == 'o/admin/photo')
					$this->addError('photos', 'Photo cannot be blank.');
			}
			
			if($this->isNewRecord) {
				/**
				 * Default action
				 * = Default register member
				 * = Random password
				 * = Username required
				 */
				$oauthCondition = 0;
				if($action == 'login' && $setting->site_oauth == 1)
					$oauthCondition = 1;
				
				$this->salt = self::getUniqueCode();
				
				if(in_array($controller, array('o/admin','o/member'))) {
					// Auto Approve Users
					if($setting->signup_approve == 1)
						$this->enabled = 1;
				
					// Auto Verified Email User
					if($setting->signup_verifyemail == 0)
						$this->verified = 1;
				
					// Generate user by admin
					$this->modified_id = !Yii::app()->user->isGuest ? Yii::app()->user->id : 0;
					
				} else {
					$this->level_id = UserLevel::getDefault();
					$this->enabled = $setting->signup_approve == 1 ? 1 : 0;
					$this->verified = $setting->signup_verifyemail == 0 ? 1 : 0;

					// Signup by Invite (Admin or User)
					if(($setting->site_type == 1 && $setting->signup_inviteonly != 0) && $oauthCondition == 0) {
						if($setting->signup_checkemail == 1 && $this->invite_code_i == '')
							$this->addError('invite_code_i', 'Invite Code tidak boleh kosong.');
						
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
											$code = UserInvites::model()->findByAttributes(array('code' => $this->invite_code_i), array(
												'select' => 'queue_id, user_id, code',
											));
											if($code == null)
												$this->addError('invite_code_i', 'Invite Code yang and masukan salah.');
											else
												$this->reference_id_i = $code->user_id;
										}
									}
								}
							} else
								$this->addError('email', 'Email anda belum ada dalam daftar invite.');
							
						} else {
							if($setting->signup_checkemail == 1)
								$this->addError('invite_code_i', 'Invite Code yang and masukan salah, silahkan lengkapi input email');
						}
					}
				}

				// Username required
				if($setting->signup_username == 1 && $oauthCondition == 0) {
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
				if($setting->signup_random == 1 || $oauthCondition == 1) {
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
					if(!in_array($controller, array('password')))
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
	protected function beforeSave() 
	{
		if(parent::beforeSave()) {
			$this->email = strtolower($this->email);
			$this->username = strtolower($this->username);
			if($this->newPassword != '')
				$this->password = self::hashPassword($this->salt, $this->newPassword);

			if(!$this->isNewRecord) {
				// Add User Folder
				$user_path = 'public/users/'.$this->user_id;
				if(!file_exists($user_path)) {
					mkdir($user_path, 0755, true);

					// Add File in User Folder (index.php)
					$newFile = $user_path.'/index.php';
					$FileHandle = fopen($newFile, 'w');
				} else
					@chmod($user_path, 0755, true);
				
				$this->photos = CUploadedFile::getInstance($this, 'photos');
				if($this->photos != null) {
					if($this->photos instanceOf CUploadedFile) {
						$fileName = time().'_'.Utility::getUrlTitle($this->displayname).'.'.strtolower($this->photos->extensionName);
						if($this->photos->saveAs($user_path.'/'.$fileName)) {							
							if($this->old_photos_i != '' && file_exists($user_path.'/'.$this->old_photos_i))
								rename($user_path.'/'.$this->old_photos_i, 'public/users/verwijderen/'.$this->user_id.'_'.$this->old_photos_i);
							$this->photos = $fileName;
						}
					}
				} else {
					if($this->photos == '')
						$this->photos = $this->old_photos_i;
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
		$setting = OmmuSettings::model()->findByPk(1, array(
			'select' => 'site_type, site_title, signup_welcome, signup_adminemail',
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
			$user_path = 'public/users/'.$this->user_id;
			if(!file_exists($user_path)) {
				mkdir($user_path, 0755, true);

				// Add File in User Folder (index.php)
				$newFile = $user_path.'/index.php';
				$FileHandle = fopen($newFile, 'w');
			} else
				@chmod($user_path, 0755, true);

			$this->photos = CUploadedFile::getInstance($this, 'photos');
			if($this->photos != null) {
				if($this->photos instanceOf CUploadedFile) {
					$fileName = time().'_'.Utility::getUrlTitle($this->displayname).'.'.strtolower($this->photos->extensionName);
					if($this->photos->saveAs($user_path.'/'.$fileName)) {
						self::model()->updateByPk($this->user_id, array('photos'=>$fileName));
					}
				}
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
			if($setting->site_type == 1) {
				$invite = UserInviteQueue::model()->findByAttributes(array('email' => strtolower($this->email)), array(
					'select' => 'queue_id, member_id, reference_id',
				));
				if($invite != null && $invite->member_id == 0) {
					$invite->member_id = $this->user_id;
					if($this->reference_id_i != '')
						$invite->reference_id = $this->reference_id_i;
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
					'{$baseURL}', '{$displayname}', '{$site_support_email}',
					'{$site_title}', '{$index}',
				);
				$welcome_replace = array(
					Utility::getProtocol().'://'.Yii::app()->request->serverName.$_assetsUrl, $this->displayname, SupportMailSetting::getInfo('mail_contact'), 
					$setting->site_title, Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->createUrl('site/index'),
				);
				$welcome_template = 'user_welcome';
				$welcome_title = 'Welcome to '.$setting->site_title;
				$welcome_message = file_get_contents(YiiBase::getPathOfAlias('application.modules.users.components.templates').'/'.$welcome_template.'.php');
				$welcome_ireplace = str_ireplace($welcome_search, $welcome_replace, $welcome_message);
				SupportMailSetting::sendEmail($this->email, $this->displayname, $welcome_title, $welcome_ireplace);
			}

			// Send Account Information
			$account_search = array(
				'{$baseURL}', '{$displayname}', '{$site_support_email}',
				'{$site_title}', '{$email}', '{$password}', '{$login}'
			);
			$account_replace = array(
				Utility::getProtocol().'://'.Yii::app()->request->serverName.$_assetsUrl, $this->displayname, SupportMailSetting::getInfo('mail_contact'),
				$setting->site_title, $this->email, $this->newPassword, Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->createUrl('site/login'),
			);
			$account_template = 'user_welcome_account';
			$account_title = $setting->site_title.' Account ('.$this->displayname.')';
			$account_message = file_get_contents(YiiBase::getPathOfAlias('application.modules.users.components.templates').'/'.$account_template.'.php');
			$account_ireplace = str_ireplace($account_search, $account_replace, $account_message);
			SupportMailSetting::sendEmail($this->email, $this->displayname, $account_title, $account_ireplace);

			// Send New Account to Email Administrator
			if($setting->signup_adminemail == 1)
				SupportMailSetting::sendEmail(null, null, 'New Member', 'informasi member terbaru');
			
		} else {
			// Send Account Information
			//if($this->enabled == 1) {}
			if($controller == 'password') {
				$account_search = array(
					'{$baseURL}', '{$displayname}', '{$site_support_email}',
					'{$site_title}', '{$email}', '{$password}', '{$login}',
				);
				$account_replace = array(
					Utility::getProtocol().'://'.Yii::app()->request->serverName.$_assetsUrl, $this->displayname, SupportMailSetting::getInfo('mail_contact'),
					$setting->site_title, $this->email, $this->newPassword, Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->createUrl('site/login'),
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
	 * After delete attributes
	 */
	protected function afterDelete() {
		parent::afterDelete();
		//delete user image
		$user_path = 'public/users/'.$this->user_id;
		if($this->photos != '' && file_exists($user_path.'/'.$this->photos))
			rename($user_path.'/'.$this->photos, 'public/users/verwijderen/'.$this->user_id.'_'.$this->photos);
		
		Utility::deleteFolder($user_path);		
	}

}