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
 * This is the model class for table "ommu_user_newsletter".
 *
 * The followings are the available columns in table 'ommu_user_newsletter':
 * @property string $id
 * @property string $user_id
 * @property string $email
 * @property integer $subscribe
 * @property string $subscribe_date
 * @property string $unsubscribe_date
 * @property string $unsubscribe_ip
 */
class UserNewsletter extends CActiveRecord
{
	public $defaultColumns = array();
	public $unsubscribe;
	
	// Variable Search
	public $user_search;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserNewsletter the static model class
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
		return 'ommu_user_newsletter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email', 'required'),
			array('subscribe,
				unsubscribe', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('email', 'length', 'max'=>32),
			array('unsubscribe_ip', 'length', 'max'=>20),
			array('email', 'email'),
			array('user_id, subscribe, subscribe_date, unsubscribe_date, unsubscribe_ip,
				unsubscribe', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, email, subscribe, subscribe_date, unsubscribe_date, unsubscribe_ip,
				user_search', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'user_id' => Phrase::trans(16001,1),
			'email' => Phrase::trans(16108,1),
			'subscribe' => Phrase::trans(23057,1),
			'subscribe_date' => Phrase::trans(23058,1),
			'unsubscribe_date' => Phrase::trans(23059,1),
			'unsubscribe_ip' => Phrase::trans(23060,1),
			'user_id' => Phrase::trans(16001,1),
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
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.email',$this->email,true);
		$criteria->compare('t.subscribe',$this->subscribe);
		if($this->subscribe_date != null && !in_array($this->subscribe_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.subscribe_date)',date('Y-m-d', strtotime($this->subscribe_date)));
		if($this->unsubscribe_date != null && !in_array($this->unsubscribe_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.unsubscribe_date)',date('Y-m-d', strtotime($this->unsubscribe_date)));
		$criteria->compare('t.unsubscribe_ip',$this->unsubscribe_ip,true);
		
		// Custom Search
		$criteria->with = array(
			'user' => array(
				'alias'=>'user',
				'select'=>'displayname'
			),
		);
		$criteria->compare('user.displayname',strtolower($this->user_search), true);
		
		if(!isset($_GET['UserNewsletter_sort'])) {
			$criteria->order = 'id DESC';
		}

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
			//$this->defaultColumns[] = 'id';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'email';
			$this->defaultColumns[] = 'subscribe';
			$this->defaultColumns[] = 'subscribe_date';
			$this->defaultColumns[] = 'unsubscribe_date';
			$this->defaultColumns[] = 'unsubscribe_ip';
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
			$this->defaultColumns[] = array(
				'name' => 'user_search',
				'value' => '$data->user_id != 0 ? $data->user->displayname : "-"',
			);
			$this->defaultColumns[] = array(
				'name' => 'email',
				'value' => '$data->email',
			);
			$this->defaultColumns[] = array(
				'name' => 'subscribe_date',
				'value' => 'Utility::dateFormat($data->subscribe_date, true)',
				'htmlOptions' => array(
					//'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this, 
					'attribute'=>'subscribe_date', 
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'subscribe_date_filter',
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
				'name' => 'unsubscribe_date',
				'value' => '$data->unsubscribe_date == "0000-00-00 00:00:00" ? "-" : Utility::dateFormat($data->unsubscribe_date, true)',
				'htmlOptions' => array(
					//'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this, 
					'attribute'=>'unsubscribe_date', 
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'unsubscribe_date_filter',
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
				'name' => 'unsubscribe_ip',
				'value' => '$data->unsubscribe_ip',
				'htmlOptions' => array(
					//'class' => 'center',
				),
			);
			$this->defaultColumns[] = array(
				'header' => Phrase::trans(313,0),
				'name' => 'subscribe',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("unsubscribe",array("id"=>$data->id, "type"=>"admin")), $data->subscribe, 8)',
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
		parent::afterConstruct();
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		$current = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		if(parent::beforeValidate()) {
			if($this->isNewRecord) {
				if($this->email != '') {
					$newsletter = self::model()->findByAttributes(array('email' => $this->email), array(
						'select' => 'email',
					));
					if($newsletter == null) {
						if($this->unsubscribe != 0) {
							$this->addError('email', Phrase::trans(23101,1));
						}
					} else {
						if($this->unsubscribe == 0) {
							$this->addError('email', Phrase::trans(23094,1));
						}
					}
					
				}
			}
		}
		return true;
	}

	/**
	 * before validate attributes
	 */
	/*
	protected function afterValidate() {
		if(parent::afterValidate()) {
			if($this->isNewRecord && $this->unsubscribe == 1 && $this->subscribe == 1) {
				if($this->user_id != 0) {
					$email = $this->user->email;
					$displayname = $this->user->displayname;
					$ticket = Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->createUrl('support/newsletter/unsubscribe', array('email'=>$email,'secret'=>$this->user->salt));
				} else {
					$email = $displayname = $this->email;
					$ticket = Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->createUrl('support/newsletter/unsubscribe', array('email'=>$email,'secret'=>md5($email.$this->subscribe_date)));
				}
				// Send Email to Member
				SupportMailSetting::sendEmail($email, $displayname, 'Unsubscribe Ticket', $ticket, 1);
			}
		}
		return true;
	}
	*/
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			if(!$this->isNewRecord && $this->subscribe == 0) {
				$this->unsubscribe_ip = $_SERVER['REMOTE_ADDR'];
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
			// Guest Subscribe
			if($this->user_id == 0 && $this->subscribe == 1) {
				$message = OmmuTemplate::getMessage('user_subscribe_launching', array(
					CHtml::encode($this->email),
				));
				SupportMailSetting::sendEmail($this->email, $this->email, 'Subscribe Success', $message, 1);
			}
		} else {
			if($this->subscribe == 0) {
				// Guest Unsubscribe
				if($this->user_id == 0) {
					SupportMailSetting::sendEmail($this->email, $this->email, 'Unsubscribe Success', 'Unsubscribe Success', 1);
				// Member Unsubscribe
				} else {
					SupportMailSetting::sendEmail($this->user->email, $this->user->displayname, 'Unsubscribe Success', 'Unsubscribe Success', 1);
				}
			}
		}
	}

}