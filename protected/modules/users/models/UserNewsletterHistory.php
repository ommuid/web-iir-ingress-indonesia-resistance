<?php
/**
 * UserNewsletterHistory
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2015 Ommu Platform (opensource.ommu.co)
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
 * This is the model class for table "ommu_user_newsletter_history".
 *
 * The followings are the available columns in table 'ommu_user_newsletter_history':
 * @property string $id
 * @property integer $status
 * @property string $newsletter_id
 * @property string $updated_date
 * @property string $updated_ip
 *
 * The followings are the available model relations:
 * @property OmmuUserNewsletter $newsletter
 */
class UserNewsletterHistory extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $user_search;
	public $email_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserNewsletterHistory the static model class
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
		return 'ommu_user_newsletter_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, newsletter_id, updated_date, updated_ip', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('newsletter_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, status, newsletter_id, updated_date, updated_ip,
				user_search, email_search', 'safe', 'on'=>'search'),
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
			'newsletter' => array(self::BELONGS_TO, 'UserNewsletter', 'newsletter_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('attribute', 'ID'),
			'status' => Yii::t('attribute', 'Status'),
			'newsletter_id' => Yii::t('attribute', 'Newsletter'),
			'updated_date' => Yii::t('attribute', 'Updated Date'),
			'updated_ip' => Yii::t('attribute', 'Updated IP'),
			'user_search' => Yii::t('attribute', 'User'),
			'email_search' => Yii::t('attribute', 'Email'),
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

		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.status',$this->status);
		if(isset($_GET['newsletter'])) {
			$criteria->compare('t.newsletter_id',$_GET['newsletter']);
		} else {
			$criteria->compare('t.newsletter_id',$this->newsletter_id);
		}
		if($this->updated_date != null && !in_array($this->updated_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.updated_date)',date('Y-m-d', strtotime($this->updated_date)));
		$criteria->compare('t.updated_ip',$this->updated_ip,true);
		
		// Custom Search
		$criteria->with = array(
			'newsletter.user' => array(
				'alias'=>'newsletter_user',
				'select'=>'displayname'
			),
			'newsletter' => array(
				'alias'=>'newsletter',
				'select'=>'email'
			),
		);
		$criteria->compare('newsletter_user.displayname',strtolower($this->user_search), true);
		$criteria->compare('newsletter.email',strtolower($this->email_search), true);

		if(!isset($_GET['UserNewsletterHistory_sort']))
			$criteria->order = 't.id DESC';

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
			//$this->defaultColumns[] = 'id';
			$this->defaultColumns[] = 'status';
			$this->defaultColumns[] = 'newsletter_id';
			$this->defaultColumns[] = 'updated_date';
			$this->defaultColumns[] = 'updated_ip';
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
			if(!isset($_GET['newsletter'])) {
				$this->defaultColumns[] = array(
					'name' => 'user_search',
					'value' => '$data->newsletter->user_id ? $data->newsletter->user->displayname : "-"',
				);
				$this->defaultColumns[] = array(
					'name' => 'email_search',
					'value' => '$data->newsletter->email',
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'status',
				'value' => '$data->status == 1 ? Yii::t(\'phrase\', \'Subscribe\') : Yii::t(\'phrase\', \'Unsubscribe\')',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>Yii::t('phrase', 'Subscribe'),
					0=>Yii::t('phrase', 'Unsubscribe'),
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'updated_date',
				'value' => 'Utility::dateFormat($data->updated_date, true)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'updated_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'updated_date_filter',
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
				'name' => 'updated_ip',
				'value' => '$data->updated_ip',
				'htmlOptions' => array(
					'class' => 'center',
				),
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

}