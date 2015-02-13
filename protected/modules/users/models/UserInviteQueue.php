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
 * This is the model class for table "ommu_user_invite_queue".
 *
 * The followings are the available columns in table 'ommu_user_invite_queue':
 * @property string $queue_id
 * @property string $member_id
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
	public $after_register;
	
	// Variable Search
	public $member_search;
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
			array('member_id, reference_id', 'length', 'max'=>11),
			array('email', 'length', 'max'=>32),
			array('email', 'email'),
			array('', 'safe', 'on'=>'search'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('queue_id, member_id, reference_id, email, invite,
				member_search, reference_search', 'safe', 'on'=>'search'),
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
			'invite' => array(self::HAS_MANY, 'UserInvites', 'queue_id'),
			'member' => array(self::BELONGS_TO, 'Users', 'member_id'),
			'reference' => array(self::BELONGS_TO, 'Users', 'reference_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'queue_id' => Phrase::trans(16215,1),
			'member_id' => Phrase::trans(16173,1),
			'reference_id' => Phrase::trans(16216,1),
			'email' => Phrase::trans(16108,1),
			'invite' => Phrase::trans(16172,1),
			'member_search' => Phrase::trans(16173,1),
			'reference_search' => Phrase::trans(16216,1),
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
		$criteria->compare('t.member_id',$this->member_id);
		$criteria->compare('t.reference_id',$this->reference_id);
		$criteria->compare('t.email',strtolower($this->email),true);
		$criteria->compare('t.invite',$this->invite);
		
		// Custom Search
		$criteria->with = array(
			'member' => array(
				'alias'=>'member',
				'select'=>'displayname'
			),
			'reference' => array(
				'alias'=>'reference',
				'select'=>'displayname'
			),
		);
		$criteria->compare('member.displayname',strtolower($this->member_search), true);
		$criteria->compare('reference.displayname',strtolower($this->reference_search), true);
		
		if(!isset($_GET['UserInviteQueue_sort']))
			$criteria->order = 'queue_id DESC';

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
			$this->defaultColumns[] = 'member_id';
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
				'name' => 'member_search',
				'value' => '$data->member_id == 0 ? "-" : $data->member->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'reference_search',
				'value' => '$data->reference_id == 0 ? "-" : $data->reference->displayname',
			);
			$this->defaultColumns[] = 'email';
			$this->defaultColumns[] = array(
				'name' => 'inviters',
				'value' => 'CHtml::link($data->inviters." ".Phrase::trans(16172, 1), Yii::app()->controller->createUrl("invite/manage",array("queue"=>$data->queue_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'invite',
				'value' => '$data->invite == 1 ? Phrase::trans(16220,1) : Phrase::trans(16221,1)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>Phrase::trans(16220,1),
					0=>Phrase::trans(16221,1),
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
			if($this->invite == 0) {
				$this->invite = Yii::app()->user->level == 1 ? 1 : 0;
			}
		}
		return true;
	}
}