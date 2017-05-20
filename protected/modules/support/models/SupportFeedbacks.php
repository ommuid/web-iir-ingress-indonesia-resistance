<?php
/**
 * SupportFeedbacks
 * version: 0.2.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Support
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
 * This is the model class for table "ommu_support_feedbacks".
 *
 * The followings are the available columns in table 'ommu_support_feedbacks':
 * @property string $feedback_id
 * @property string $user_id
 * @property string $email
 * @property string $displayname
 * @property string $phone
 * @property string $subject
 * @property string $message
 * @property string $creation_date
 * @property string $modified_date
 * @property string $modified_id
 */
class SupportFeedbacks extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $user_search;
	public $modified_search;
	public $view_search;
	public $reply_search;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SupportFeedbacks the static model class
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
		return 'ommu_support_feedbacks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, displayname, subject, message', 'required'),
			//array('displayname, phone', 'required', 'on'=>'contactus'),
			array('modified_id', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('phone', 'length', 'max'=>15),
			array('email, displayname', 'length', 'max'=>32),
			array('subject', 'length', 'max'=>64),
			array('email', 'email'),
			array('user_id, displayname, phone, creation_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('feedback_id, user_id, email, displayname, phone, subject, message, creation_date, modified_date, modified_id,
				user_search, modified_search, view_search, reply_search', 'safe', 'on'=>'search'),
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
			'view' => array(self::BELONGS_TO, 'ViewSupportFeedbacks', 'feedback_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			'replies' => array(self::HAS_MANY, 'SupportFeedbackReply', 'feedback_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'feedback_id' => Yii::t('attribute', 'Feedback'),
			'user_id' => Yii::t('attribute', 'User'),
			'email' => Yii::t('attribute', 'Email Address'),
			'displayname' => Yii::t('attribute', 'Name'),
			'phone' => Yii::t('attribute', 'Phone'),
			'subject' => Yii::t('attribute', 'Subject'),
			'message' => Yii::t('attribute', 'Message'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'user_search' => Yii::t('attribute', 'User'),
			'modified_search' => Yii::t('attribute', 'Modified'),
			'view_search' => Yii::t('attribute', 'View'),
			'reply_search' => Yii::t('attribute', 'Reply'),
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
		
		// Custom Search
		$criteria->with = array(
			'view' => array(
				'alias'=>'view',
			),
			'user' => array(
				'alias'=>'user',
				'select'=>'displayname',
			),
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname',
			),
		);

		$criteria->compare('t.feedback_id',$this->feedback_id);
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.email',$this->email,true);
		$criteria->compare('t.displayname',$this->displayname,true);
		$criteria->compare('t.phone',$this->phone,true);
		$criteria->compare('t.subject',$this->subject,true);
		$criteria->compare('t.message',$this->message,true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id',$this->modified_id);
		
		$criteria->compare('user.displayname',strtolower($this->user_search), true);
		$criteria->compare('modified.displayname',strtolower($this->modified_search), true);
		$criteria->compare('view.view_condition',$this->view_search);
		$criteria->compare('view.reply_condition',$this->reply_search);
			
		if(!isset($_GET['SupportFeedbacks_sort']))
			$criteria->order = 't.feedback_id DESC';

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
			//$this->defaultColumns[] = 'feedback_id';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'email';
			$this->defaultColumns[] = 'displayname';
			$this->defaultColumns[] = 'phone';
			$this->defaultColumns[] = 'subject';
			$this->defaultColumns[] = 'message';
			$this->defaultColumns[] = 'creation_date';
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
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			$this->defaultColumns[] = array(
				'name' => 'subject',
				'value' => '$data->subject != "" ? $data->subject : "-"',
			);
			$this->defaultColumns[] = 'email';
			$this->defaultColumns[] = array(
				'name' => 'displayname',
				'value' => '$data->user_id != 0 ? $data->user->displayname : ($data->displayname != "" ? $data->displayname : "-")',
			);
			$this->defaultColumns[] = array(
				'name' => 'phone',
				'value' => '$data->phone != "" ? $data->phone : "-"',
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
				'name' => 'view_search',
				'value' => '$data->view->view_condition != 0 ? CHtml::link($data->view->views, Yii::app()->controller->createUrl("o/views/manage",array(\'feedback\'=>$data->feedback_id))) : Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/unpublish.png\') ',
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
				'name' => 'reply_search',
				'value' => '$data->view->reply_condition != 0 ? CHtml::link($data->view->replies, Yii::app()->controller->createUrl("o/reply/manage",array(\'feedback\'=>$data->feedback_id))) : Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/unpublish.png\') ',
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
	 * before validate attributes
	 */
	protected function beforeValidate() {
		$action = strtolower(Yii::app()->controller->action->id);
		
		if(parent::beforeValidate()) {
			if(!$this->isNewRecord) {
				if($action == 'edit')
					$this->modified_id = Yii::app()->user->id;
			}	
		}
		return true;
	}
	
	/**
	 * After save attributes
	 */
	protected function afterSave() 
	{
		$action = strtolower(Yii::app()->controller->action->id);
		$setting = OmmuSettings::model()->findByPk(1, array(
			'select' => 'site_title',
		));
		
		parent::afterSave();
		if($this->isNewRecord) {
			// Send Email to Member
			$feedback_search = array(
				'{$subject}','{$displayname}','{$email}','{$creation_date}','{$message}',
			);
			$feedback_replace = array(
				$this->subject, $this->displayname, $this->email, Utility::dateFormat(date('Y-m-d H:i:s'), true), $this->message,
			);
			$feedback_template = 'support_feedback';
			$feedback_title = Yii::t('phrase', '[Feedback]').' '.$this->subject.' | '.$setting->site_title;
			$feedback_message = file_get_contents(YiiBase::getPathOfAlias('webroot.protected.modules.support.components.template').'/'.$feedback_template.'.php');			
			$feedback_ireplace = str_ireplace($feedback_search, $feedback_replace, $feedback_message);
			SupportMailSetting::sendEmail(null, null, $feedback_title, $feedback_ireplace);
			
		} //else {
		/*
			if($action == 'reply') {
				$reply_search = array(
					'{$displayname}','{$email}','{$creation_date}','{$subject}','{$message}','{$reply}',
					'{$reply_displayname}','{$reply_email}',
				);
				$reply_replace = array(
					$this->displayname, $this->email, Utility::dateFormat($this->creation_date, true), $this->subject, $this->message, $this->message_reply,
					$this->user_reply->displayname, $this->user_reply->email,
				);
				$reply_template = 'support_feedback_reply';
				$reply_title = Yii::t('phrase', '[Reply]').' '.$this->subject.' | '.$setting->site_title;
				$reply_message = file_get_contents(YiiBase::getPathOfAlias('webroot.protected.modules.support.components.template').'/'.$reply_template.'.php');			
				$reply_ireplace = str_ireplace($reply_search, $reply_replace, $reply_message);
				SupportMailSetting::sendEmail($this->email, $this->displayname, $reply_title, $reply_ireplace);
			}
		}
		*/
	}

}