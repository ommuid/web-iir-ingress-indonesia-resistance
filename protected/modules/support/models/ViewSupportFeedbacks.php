<?php
/**
 * ViewSupportFeedbacks
 * version: 0.2.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 16 February 2017, 18:03 WIB
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
 * This is the model class for table "_view_support_feedbacks".
 *
 * The followings are the available columns in table '_view_support_feedbacks':
 * @property string $feedback_id
 * @property string $reply_condition
 * @property string $replies
 * @property string $reply_all
 * @property string $view_condition
 * @property string $views
 * @property string $users
 */
class ViewSupportFeedbacks extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewSupportFeedbacks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the primarykey column
	 */
	public function primaryKey()
	{
		return 'feedback_id';
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '_view_support_feedbacks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('reply_condition, view_condition', 'numerical', 'integerOnly'=>true),
			array('feedback_id', 'length', 'max'=>11),
			array('replies, views, users', 'length', 'max'=>23),
			array('reply_all', 'length', 'max'=>21),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('feedback_id, reply_condition, replies, reply_all, view_condition, views, users', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'feedback_id' => Yii::t('attribute', 'Feedback'),
			'reply_condition' => Yii::t('attribute', 'Reply'),
			'replies' => Yii::t('attribute', 'Replies'),
			'reply_all' => Yii::t('attribute', 'Reply All'),
			'view_condition' => Yii::t('attribute', 'View'),
			'views' => Yii::t('attribute', 'Views'),
			'users' => Yii::t('attribute', 'Users'),
		);
		/*
			'Feedback' => 'Feedback',
			'Feedbacks' => 'Feedbacks',
			'Feedback All' => 'Feedback All',
		
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

		$criteria->compare('t.feedback_id',strtolower($this->feedback_id),true);
		$criteria->compare('t.reply_condition',strtolower($this->reply_condition),true);
		$criteria->compare('t.replies',strtolower($this->replies),true);
		$criteria->compare('t.reply_all',strtolower($this->reply_all),true);
		$criteria->compare('t.view_condition',strtolower($this->view_condition),true);
		$criteria->compare('t.views',strtolower($this->views),true);
		$criteria->compare('t.users',strtolower($this->users),true);

		if(!isset($_GET['ViewSupportFeedbacks_sort']))
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
		} else {
			$this->defaultColumns[] = 'feedback_id';
			$this->defaultColumns[] = 'reply_condition';
			$this->defaultColumns[] = 'replies';
			$this->defaultColumns[] = 'reply_all';
			$this->defaultColumns[] = 'view_condition';
			$this->defaultColumns[] = 'views';
			$this->defaultColumns[] = 'users';
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
			//$this->defaultColumns[] = 'feedback_id';
			$this->defaultColumns[] = 'reply_condition';
			$this->defaultColumns[] = 'replies';
			$this->defaultColumns[] = 'reply_all';
			$this->defaultColumns[] = 'view_condition';
			$this->defaultColumns[] = 'views';
			$this->defaultColumns[] = 'users';
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