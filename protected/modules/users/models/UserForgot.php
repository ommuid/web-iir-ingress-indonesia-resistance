<?php
/**
 * UserForgot
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
 * This is the model class for table "ommu_user_forgot".
 *
 * The followings are the available columns in table 'ommu_user_forgot':
 * @property string $forgot_id
 * @property integer $publish
 * @property string $user_id
 * @property string $code
 * @property string $forgot_date
 * @property string $forgot_ip
 * @property string $deleted_date
 *
 * The followings are the available model relations:
 * @property OmmuUsers $user
 */
class UserForgot extends CActiveRecord
{
	public $defaultColumns = array();
	public $email_i;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserForgot the static model class
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
		return 'ommu_user_forgot';
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
			array('forgot_ip', 'length', 'max'=>20),
			array('email_i', 'email'),
			array('user_id, forgot_ip,
				email_i', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('forgot_id, publish, user_id, code, forgot_date, forgot_ip, deleted_date', 'safe', 'on'=>'search'),
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
			'forgot_id' => Yii::t('attribute', 'Forgot'),
			'publish' => Yii::t('attribute', 'Publish'),
			'user_id' => Yii::t('attribute', 'User'),
			'code' => Yii::t('attribute', 'Forgot Code'),
			'forgot_date' => Yii::t('attribute', 'Forgot Date'),
			'forgot_ip' => Yii::t('attribute', 'Forgot Ip'),
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

		$criteria->compare('t.forgot_id',$this->forgot_id);
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
		if($this->forgot_date != null && !in_array($this->forgot_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.forgot_date)',date('Y-m-d', strtotime($this->forgot_date)));
		$criteria->compare('t.forgot_ip',$this->forgot_ip,true);
		if($this->deleted_date != null && !in_array($this->deleted_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.deleted_date)',date('Y-m-d', strtotime($this->deleted_date)));

		if(!isset($_GET['UserForgot_sort']))
			$criteria->order = 't.forgot_id DESC';

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
			//$this->defaultColumns[] = 'forgot_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'code';
			$this->defaultColumns[] = 'forgot_date';
			$this->defaultColumns[] = 'forgot_ip';
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
				'name' => 'forgot_date',
				'value' => 'Utility::dateFormat($data->forgot_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.components.system.CJuiDatePicker', array(
					'model'=>$this, 
					'attribute'=>'forgot_date', 
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'forgot_date_filter',
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
			$this->defaultColumns[] = 'forgot_ip';
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
	 * User forgot password codes
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
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		if(parent::beforeValidate()) {		
			if($this->isNewRecord) {
				if($currentAction == 'password/forgot' && $this->email_i != '') {
					$user = Users::model()->findByAttributes(array('email' => $this->email_i), array(
						'select' => 'user_id, email',
					));
					if($user == null) {
						$this->addError('email_i', 'Incorrect email address');
					} else {
						$this->user_id = $user->user_id;
					}
				}
				$this->code = self::getUniqueCode();
				$this->forgot_ip = $_SERVER['REMOTE_ADDR'];
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
			$forgot_search = array(
				'{$baseURL}', '{$displayname}', '{$site_support_email}',
				'{$forgot_link}',
			);
			$forgot_replace = array(
				Utility::getProtocol().'://'.Yii::app()->request->serverName.$_assetsUrl, $this->user->displayname, SupportMailSetting::getInfo('mail_contact'),
				Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->createUrl('users/password/verify',array('key'=>$this->code, 'secret'=>$this->user->salt)),
			);
			$forgot_template = 'user_forgot_password';
			$forgot_title = $setting->site_title.' Password Assistance';
			$forgot_message = file_get_contents(YiiBase::getPathOfAlias('application.modules.users.components.templates').'/'.$forgot_template.'.php');
			$forgot_ireplace = str_ireplace($forgot_search, $forgot_replace, $forgot_message);
			SupportMailSetting::sendEmail($this->user->email, $this->user->displayname, $forgot_title, $forgot_ireplace);

			// Update all history
			$criteria=new CDbCriteria;
			$criteria->addNotInCondition('forgot_id', array($this->forgot_id));
			$criteria->compare('publish',1);
			$criteria->compare('user_id',$this->user_id);

			self::model()->updateAll(array('publish'=>0), $criteria);
			
		}
	}

}