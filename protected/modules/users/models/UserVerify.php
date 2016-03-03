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
 * This is the model class for table "ommu_user_verify".
 *
 * The followings are the available columns in table 'ommu_user_verify':
 * @property string $verify_id
 * @property string $user_id
 * @property string $code
 * @property string $verify_date
 * @property string $verify_ip
 *
 * The followings are the available model relations:
 * @property OmmuUsers $user
 */
class UserVerify extends CActiveRecord
{
	public $defaultColumns = array();
	public $email;

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
			array('email', 'required', 'on'=>'get'),
			array('user_id', 'length', 'max'=>11),
			array('
				email', 'length', 'max'=>32),
			array('code', 'length', 'max'=>64),
			array('verify_ip', 'length', 'max'=>20),
			array('email', 'email'),
			array('user_id, verify_date, verify_ip,
				email', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('verify_id, user_id, code, verify_date, verify_ip', 'safe', 'on'=>'search'),
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
			'verify_id' => Phrase::trans(16141,1),
			'user_id' => Phrase::trans(16001,1),
			'code' => Phrase::trans(16142,1),
			'verify_date' => Phrase::trans(16143,1),
			'verify_ip' => Phrase::trans(16144,1),
			'email' => Phrase::trans(16108,1),
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
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.code',$this->code,true);
		if($this->verify_date != null && !in_array($this->verify_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.verify_date)',date('Y-m-d', strtotime($this->verify_date)));
		$criteria->compare('t.verify_ip',$this->verify_ip,true);

		if(!isset($_GET['UserVerify_sort']))
			$criteria->order = 'verify_id DESC';

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
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'code';
			$this->defaultColumns[] = 'verify_date';
			$this->defaultColumns[] = 'verify_ip';
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
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this, 
					'attribute'=>'verify_date', 
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
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
				if($current == 'verify/get' && $this->email != '') {
					$user = Users::model()->findByAttributes(array('email' => $this->email), array(
						'select' => 'user_id, email, verified',
					));
					if($user == null) {
						$this->addError('email', Phrase::trans(16186,1));
					} else {
						if($user->verified == 1) {
							$this->addError('email', Phrase::trans(16198,1));
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

		if($this->isNewRecord) {
			// Send Email to Member
			SupportMailSetting::sendEmail($this->user->email, $this->user->displayname, 'Verify Email', 'http://localhost'.Yii::app()->createUrl("users/verify/code",array('key'=>$this->code, 'secret'=>$this->user->salt)), 1);
		}
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() {
		parent::afterDelete();

		// Delete all history
		self::model()->deleteAll(array(
			'condition'=> 'user_id = :id',
			'params'=>array(
				':id'=>$this->user_id,
			),
		));
	}

}