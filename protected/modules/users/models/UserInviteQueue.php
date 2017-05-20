<?php
/**
 * UserInviteQueue
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
 * This is the model class for table "ommu_user_invite_queue".
 *
 * The followings are the available columns in table 'ommu_user_invite_queue':
 * @property string $queue_id
 * @property string $user_id
 * @property string $reference_id
 * @property string $email
 * @property integer $invite
 *
 * The followings are the available model relations:
 * @property OmmuUserInvites[] $ommuUserInvites
 */
class UserInviteQueue extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $user_search;
	public $reference_search;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserInviteQueue the static model class
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
		return 'ommu_user_invite_queue';
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
			array('invite', 'numerical', 'integerOnly'=>true),
			array('user_id, reference_id', 'length', 'max'=>11),
			array('email', 'length', 'max'=>32),
			array('email', 'email'),
			array('', 'safe', 'on'=>'search'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('queue_id, user_id, reference_id, email, invite,
				user_search, reference_search', 'safe', 'on'=>'search'),
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
			'reference' => array(self::BELONGS_TO, 'Users', 'reference_id'),
			'invite' => array(self::HAS_MANY, 'UserInvites', 'queue_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'queue_id' => Yii::t('attribute', 'Queue'),
			'user_id' => Yii::t('attribute', 'User'),
			'reference_id' => Yii::t('attribute', 'Reference'),
			'email' => Yii::t('attribute', 'Email'),
			'invite' => Yii::t('attribute', 'Invite'),
			'user_search' => Yii::t('attribute', 'Member'),
			'reference_search' => Yii::t('attribute', 'Reference'),
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

		$criteria->compare('t.queue_id',$this->queue_id);
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.reference_id',$this->reference_id);
		$criteria->compare('t.email',strtolower($this->email),true);
		$criteria->compare('t.invite',$this->invite);
		
		// Custom Search
		$criteria->with = array(
			'user' => array(
				'alias'=>'user',
				'select'=>'displayname'
			),
			'reference' => array(
				'alias'=>'reference',
				'select'=>'displayname'
			),
		);
		$criteria->compare('user.displayname',strtolower($this->user_search), true);
		$criteria->compare('reference.displayname',strtolower($this->reference_search), true);
		
		if(!isset($_GET['UserInviteQueue_sort']))
			$criteria->order = 't.queue_id DESC';

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
			//$this->defaultColumns[] = 'queue_id';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'reference_id';
			$this->defaultColumns[] = 'email';
			$this->defaultColumns[] = 'invite';
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
				'value' => '$data->user_id == 0 ? "-" : $data->user->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'reference_search',
				'value' => '$data->reference_id == 0 ? "-" : $data->reference->displayname',
			);
			$this->defaultColumns[] = 'email';
			$this->defaultColumns[] = array(
				'name' => 'inviters',
				'value' => 'CHtml::link($data->inviters." ".Yii::t(\'phrase\', \'Invite\'), Yii::app()->controller->createUrl("o/invite/manage",array("queue"=>$data->queue_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'invite',
				'value' => '$data->invite == 1 ? Yii::t(\'phrase\', \'by Admin\') : Yii::t(\'phrase\', \'by Member\')',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>Yii::t('phrase', 'by Admin'),
					0=>Yii::t('phrase', 'by Member'),
				),
			);
		}
		parent::afterConstruct();
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->invite == 0)
				$this->invite = Yii::app()->user->level == 1 ? 1 : 0;
			
			if($this->isNewRecord)
				$this->reference_id = Yii::app()->user->id;
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$this->email = strtolower($this->email);
		}
		return true;	
	}
}