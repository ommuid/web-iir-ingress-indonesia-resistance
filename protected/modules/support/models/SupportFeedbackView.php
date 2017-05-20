<?php
/**
 * SupportFeedbackView
 * version: 0.2.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 11 May 2017, 23:12 WIB
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
 * This is the model class for table "ommu_support_feedback_view".
 *
 * The followings are the available columns in table 'ommu_support_feedback_view':
 * @property string $view_id
 * @property string $feedback_id
 * @property string $user_id
 * @property integer $views
 * @property string $creation_date
 *
 * The followings are the available model relations:
 * @property OmmuSupportFeedbacks $feedback
 */
class SupportFeedbackView extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $subject_search;
	public $user_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SupportFeedbackView the static model class
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
		return 'ommu_support_feedback_view';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('feedback_id, user_id', 'required'),
			array('views', 'numerical', 'integerOnly'=>true),
			array('feedback_id, user_id, views', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('view_id, feedback_id, user_id, views, creation_date,
				subject_search, user_search', 'safe', 'on'=>'search'),
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
			'feedback' => array(self::BELONGS_TO, 'SupportFeedbacks', 'feedback_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'view_id' => Yii::t('attribute', 'View'),
			'feedback_id' => Yii::t('attribute', 'Feedback'),
			'user_id' => Yii::t('attribute', 'User'),
			'views' => Yii::t('attribute', 'Views'),
			'creation_date' => Yii::t('attribute', 'Viewed Date'),
			'subject_search' => Yii::t('attribute', 'Subject'),
			'user_search' => Yii::t('attribute', 'User'),
		);
		/*
			'View' => 'View',
			'Feedback' => 'Feedback',
			'User' => 'User',
			'Creation Date' => 'Creation Date',
		
		*/
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

		$criteria=new CDbCriteria;
		
		// Custom Search
		$criteria->with = array(
			'feedback' => array(
				'alias'=>'feedback',
				'select'=>'subject',
			),
			'user' => array(
				'alias'=>'user',
				'select'=>'displayname',
			),
		);

		$criteria->compare('t.view_id',strtolower($this->view_id),true);
		if(isset($_GET['feedback']))
			$criteria->compare('t.feedback_id',$_GET['feedback']);
		else
			$criteria->compare('t.feedback_id',$this->feedback_id);
		if(isset($_GET['user']))
			$criteria->compare('t.user_id',$_GET['user']);
		else
			$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.views',$this->views);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		
		$criteria->compare('feedback.subject',strtolower($this->subject_search), true);
		$criteria->compare('user.displayname',strtolower($this->user_search), true);

		if(!isset($_GET['SupportFeedbackView_sort']))
			$criteria->order = 't.view_id DESC';

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
			//$this->defaultColumns[] = 'view_id';
			$this->defaultColumns[] = 'feedback_id';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'views';
			$this->defaultColumns[] = 'creation_date';
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
			if(!isset($_GET['feedback'])) {
				$this->defaultColumns[] = array(
					'name' => 'subject_search',
					'value' => '$data->feedback->subject ? $data->feedback->subject : \'-\'',
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'user_search',
				'value' => '$data->user->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'views',
				'value' => '$data->views ? $data->views : \'0\'',
				'htmlOptions' => array(
					//'class' => 'center',
				),
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Utility::dateFormat($data->creation_date)',
				'htmlOptions' => array(
					//'class' => 'center',
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
	 * User get information
	 */
	public static function insertView($feedback_id)
	{
		$criteria=new CDbCriteria;
		$criteria->select = 'view_id, feedback_id, user_id, views';
		$criteria->compare('feedback_id', $feedback_id);
		$criteria->compare('user_id', Yii::app()->user->id);
		$findView = self::model()->find($criteria);
		
		if($findView != null)
			self::model()->updateByPk($findView->view_id, array('views'=>$findView->views + 1));
		
		else {
			$view=new SupportFeedbackView;
			$view->feedback_id = $feedback_id;
			$view->save();
		}
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->isNewRecord)
				$this->user_id = Yii::app()->user->id;
		}
		return true;
	}

}