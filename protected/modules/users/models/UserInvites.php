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
 * This is the model class for table "ommu_user_invites".
 *
 * The followings are the available columns in table 'ommu_user_invites':
 * @property string $invite_id
 * @property string $queue_id
 * @property string $user_id
 * @property string $code
 * @property string $invite_date
 * @property string $invite_ip
 *
 * The followings are the available model relations:
 * @property OmmuUserInviteQueue $queue
 */
class UserInvites extends CActiveRecord
{
	public $defaultColumns = array();	
	public $email;
	
	// Variable Search
	public $inviter_search;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserInvites the static model class
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
		return 'ommu_user_invites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, code,
				email', 'required'),
			array('queue_id, user_id', 'length', 'max'=>11),
			array('code', 'length', 'max'=>16),
			array('invite_ip', 'length', 'max'=>20),
			array('
				email', 'length', 'max'=>32),
			array('email', 'email'),
			array('invite_date, invite_ip', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invite_id, queue_id, user_id, code, invite_date, invite_ip,
				email, inviter_search', 'safe', 'on'=>'search'),
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
			'queue' => array(self::BELONGS_TO, 'UserInviteQueue', 'queue_id'),
			'inviter' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invite_id' => Phrase::trans(16172,1),
			'queue_id' => Phrase::trans(16215,1),
			'user_id' => Phrase::trans(16214,1),
			'code' => Phrase::trans(16211,1),
			'invite_date' => Phrase::trans(16174,1),
			'invite_ip' => Phrase::trans(16175,1),
			'email' => Phrase::trans(16108,1),
			'inviter_search' => Phrase::trans(16214,1),
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

		$criteria->compare('t.invite_id',$this->invite_id);
		if(isset($_GET['queue'])) {
			$criteria->compare('t.queue_id',$_GET['queue']);
		} else {
			$criteria->compare('t.queue_id',$this->queue_id);
		}
		if(isset($_GET['invite'])) {
			$criteria->compare('t.user_id',$_GET['invite']);
		} else {
			$criteria->compare('t.user_id',$this->user_id);
		}
		$criteria->compare('t.code',strtolower($this->code),true);
		if($this->invite_date != null && !in_array($this->invite_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.invite_date)',date('Y-m-d', strtotime($this->invite_date)));
		$criteria->compare('t.invite_ip',strtolower($this->invite_ip),true);
		
		// Custom Search
		$criteria->with = array(
			'queue' => array(
				'alias'=>'queue',
				'select'=>'email'
			),
			'inviter' => array(
				'alias'=>'inviter',
				'select'=>'displayname'
			),
		);
		$criteria->compare('queue.email',strtolower($this->email), true);
		$criteria->compare('inviter.displayname',strtolower($this->inviter_search), true);

		if(!isset($_GET['UserInvites_sort']))
			$criteria->order = 'invite_id DESC';

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
			//$this->defaultColumns[] = 'invite_id';
			$this->defaultColumns[] = 'queue_id';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'code';
			$this->defaultColumns[] = 'invite_date';
			$this->defaultColumns[] = 'invite_ip';
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
			if(!isset($_GET['queue'])) {
				$this->defaultColumns[] = array(
					'name' => 'email',
					'value' => '$data->queue->email',
				);
			}
			if(!isset($_GET['invite'])) {
				$this->defaultColumns[] = array(
					'name' => 'inviter_search',
					'value' => '$data->inviter->displayname',
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'code',
				'value' => '$data->code',
			);
			$this->defaultColumns[] = array(
				'name' => 'invite_ip',
				'value' => '$data->invite_ip',
			);
			$this->defaultColumns[] = array(
				'name' => 'invite_date',
				'value' => 'Utility::dateFormat($data->invite_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this, 
					'attribute'=>'invite_date', 
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'invite_date_filter',
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
	 * generate invite code
	 */
	public static function getUniqueCode() {
		$chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		srand((double)microtime()*1000000);
		$i = 0;
		$salt = '' ;

		while ($i <= 7) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 2);
			$salt = $salt . $tmp; 
			$i++;
		}

		return $salt;
	}

	// Get plugin list
	public static function getInvite($email, $type=null) {
		$order = ($type == null || ($type != null && $type == 'asc')) ? 'invite_id ASC' : 'invite_id DESC';
		$model = self::model()->with('queue')->find(array(
			'select' => 'invite_id, queue_id, user_id, code',
			'condition' => 'queue.email = :email',
			'params' => array(
				':email' => $email,
			),
			'order'=> $order,
		));
		
		return $model;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->email != '') {
				$model = UserInviteQueue::model()->findByAttributes(array('email' => $this->email), array(
					'select' => 'queue_id, member_id, invite',
				));
				if($model == null) {														// email belum masuk daftar invite
					$invite = new UserInviteQueue;
					$invite->email = $this->email;
					if($invite->save()) {
						$this->queue_id = $invite->queue_id;
					}
				} else {																	// email sudah dalam daftar invite
					if($model->member_id != 0) {											// email sudah menjadi member
						$this->addError('email', Phrase::trans(16213,1));
					} else {																// email belum menjadi member
						$invite = self::model()->with('queue')->find(array(
							'select' => 'invite_id',
							'condition' => 'queue.email = :email AND t.user_id = :user',
							'params' => array(
								':email' => $this->email,
								':user' => Yii::app()->user->id,
							),
						));
						if($invite == null) {
							$this->queue_id = $model->queue_id;
						} else {															// email sudah invite sebelumnya
							$this->addError('email', Phrase::trans(16212,1));
						}
					}
				}
			}
			if($this->isNewRecord) {
				$this->user_id = Yii::app()->user->id;
				$this->code = self::getUniqueCode();
				$this->invite_ip = $_SERVER['REMOTE_ADDR'];
			}
		}
		return true;
	}
	
	/**
	 * After save attributes
	 */
	protected function afterSave() {
		parent::afterSave();
		if($this->isNewRecord && $this->queue->member_id == 0) {
			$setting = OmmuSettings::model()->findByPk(1, array(
				'select' => 'signup_checkemail',
			));
			if($setting->signup_checkemail == 1) {
				SupportMailSetting::sendEmail($this->queue->email, $this->queue->email, 'User Invite', 'Silahkan bergabung dan masukkan code invite', 1);
			} else {
				SupportMailSetting::sendEmail($this->queue->email, $this->queue->email, 'User Invite', 'Silahkan bergabung', 1);
			}
		}
	}

}