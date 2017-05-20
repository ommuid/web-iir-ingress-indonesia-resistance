<?php
/**
 * UserVerify
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
 * This is the model class for table "ommu_user_verify".
 *
 * The followings are the available columns in table 'ommu_user_verify':
 * @property string $verify_id
 * @property integer $publish
 * @property string $user_id
 * @property string $code
 * @property string $verify_date
 * @property string $verify_ip
 * @property string $deleted_date
 *
 * The followings are the available model relations:
 * @property OmmuUsers $user
 */
class UserVerify extends CActiveRecord
{
	public $defaultColumns = array();
	public $email_i;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserVerify the static model class
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
		return 'ommu_user_verify';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code', 'required'),
			array('email_i', 'required', 'on'=>'get'),
			array('publish', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('
				email_i', 'length', 'max'=>32),
			array('code', 'length', 'max'=>64),
			array('verify_ip', 'length', 'max'=>20),
			array('email_i', 'email'),
			array('user_id, verify_ip,
				email_i', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('verify_id, publish, user_id, code, verify_date, verify_ip, deleted_date', 'safe', 'on'=>'search'),
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
			'verify_id' => Yii::t('attribute', 'Verify'),
			'publish' => Yii::t('attribute', 'Publish'),
			'user_id' => Yii::t('attribute', 'User'),
			'code' => Yii::t('attribute', 'Verify Code'),
			'verify_date' => Yii::t('attribute', 'Verify Date'),
			'verify_ip' => Yii::t('attribute', 'Verify Ip'),
			'deleted_date' => Yii::t('attribute', 'Deleted Date'),
			'email_i' => Yii::t('attribute', 'Email'),
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

		$criteria->compare('t.verify_id',$this->verify_id);
		if(isset($_GET['type']) && $_GET['type'] == 'publish')
			$criteria->compare('t.publish',1);
		elseif(isset($_GET['type']) && $_GET['type'] == 'unpublish')
			$criteria->compare('t.publish',0);
		elseif(isset($_GET['type']) && $_GET['type'] == 'trash')
			$criteria->compare('t.publish',2);
		else {
			$criteria->addInCondition('t.publish',array(0,1));
			$criteria->compare('t.publish',$this->publish);
		}
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.code',$this->code,true);
		if($this->verify_date != null && !in_array($this->verify_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.verify_date)',date('Y-m-d', strtotime($this->verify_date)));
		$criteria->compare('t.verify_ip',$this->verify_ip,true);
		if($this->deleted_date != null && !in_array($this->deleted_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.deleted_date)',date('Y-m-d', strtotime($this->deleted_date)));

		if(!isset($_GET['UserVerify_sort']))
			$criteria->order = 't.verify_id DESC';

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
			//$this->defaultColumns[] = 'verify_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'code';
			$this->defaultColumns[] = 'verify_date';
			$this->defaultColumns[] = 'verify_ip';
			$this->defaultColumns[] = 'deleted_date';
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
			$this->defaultColumns[] = 'code';
			$this->defaultColumns[] = array(
				'name' => 'verify_date',
				'value' => 'Utility::dateFormat($data->verify_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.components.system.CJuiDatePicker', array(
					'model'=>$this, 
					'attribute'=>'verify_date', 
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'verify_date_filter',
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
			$this->defaultColumns[] = 'verify_ip';
			$this->defaultColumns[] = array(
				'name' => 'publish',
				'value' => '$data->publish == 1 ? Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/unpublish.png\')',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>Yii::t('phrase', 'Yes'),
					0=>Yii::t('phrase', 'No'),
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'deleted_date',
				'value' => 'Utility::dateFormat($data->deleted_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.components.system.CJuiDatePicker', array(
					'model'=>$this, 
					'attribute'=>'deleted_date', 
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'deleted_date_filter',
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
	 * User verification codes
	 */
	public static function getUniqueCode() {
		$chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		srand((double)microtime()*1000000);
		$i = 0;
		$code = '' ;

		while ($i <= 31) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 2);
			$code = $code . $tmp; 
			$i++;
		}

		return $code;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		$current = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		if(parent::beforeValidate()) {		
			if($this->isNewRecord) {
				if($current == 'verify/get' && $this->email_i != '') {
					$user = Users::model()->findByAttributes(array('email' => $this->email_i), array(
						'select' => 'user_id, email, verified',
					));
					if($user == null) {
						$this->addError('email_i', Yii::t('phrase', 'Incorrect email address'));
					} else {
						if($user->verified == 1) {
							$this->addError('email_i', Yii::t('phrase', 'Your account verified'));
						} else {
							$this->user_id = $user->user_id;
						}
					}
				}
				$this->code = self::getUniqueCode();
				$this->verify_ip = $_SERVER['REMOTE_ADDR'];
			}		
		}
		return true;
	}
	
	/**
	 * After save attributes
	 */
	protected function afterSave() {
		parent::afterSave();
		
		$setting = OmmuSettings::model()->findByPk(1, array(
			'select' => 'site_title',
		));
		$_assetsUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('users.assets'));

		if($this->isNewRecord) {
			// Send Email to Member
			$verify_search = array(
				'{$baseURL}', '{$displayname}', '{$site_support_email}',
				'{$site_title}', '{$verify_link}',
			);
			$verify_replace = array(
				Utility::getProtocol().'://'.Yii::app()->request->serverName.$_assetsUrl, $this->user->displayname, SupportMailSetting::getInfo('mail_contact'),
				$setting->site_title, Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->createUrl('users/verify/code',array('key'=>$this->code, 'secret'=>$this->user->salt)),
			);
			$verify_template = 'user_verify_email';
			$verify_title = 'Please verify your '.$setting->site_title.' account';
			$verify_message = file_get_contents(YiiBase::getPathOfAlias('application.modules.users.components.templates').'/'.$verify_template.'.php');
			$verify_ireplace = str_ireplace($verify_search, $verify_replace, $verify_message);
			SupportMailSetting::sendEmail($this->user->email, $this->user->displayname, $verify_title, $verify_ireplace);

			// Update all history
			$criteria=new CDbCriteria;
			$criteria->addNotInCondition('verify_id', array($this->verify_id));
			$criteria->compare('publish',1);
			$criteria->compare('user_id',$this->user_id);

			self::model()->updateAll(array('publish'=>0), $criteria);
			
		}
	}

}