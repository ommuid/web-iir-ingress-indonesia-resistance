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
 * This is the model class for table "ommu_user_level".
 *
 * The followings are the available columns in table 'ommu_user_level':
 * @property integer $level_id
 * @property string $name
 * @property string $desc
 * @property integer $defaults
 * @property integer $signup
 * @property integer $message_allow
 * @property integer $message_inbox
 * @property integer $message_outbox
 * @property integer $profile_block
 * @property integer $profile_search
 * @property string $profile_privacy
 * @property string $profile_comments
 * @property integer $profile_style
 * @property integer $profile_style_sample
 * @property integer $profile_status
 * @property integer $profile_invisible
 * @property integer $profile_views
 * @property integer $profile_change
 * @property integer $profile_delete
 * @property integer $photo_allow
 * @property integer $photo_width
 * @property integer $photo_height
 * @property string $photo_exts
 * @property string $creation_date
 */
class UserLevel extends CActiveRecord
{
	public $defaultColumns = array();
	public $title;
	public $description;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserLevel the static model class
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
		return 'ommu_user_level';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('
				title, description', 'required', 'on'=>'info'),
			array('profile_block, profile_search, profile_privacy, profile_comments, photo_allow, photo_width, photo_height, photo_exts, profile_style, profile_style_sample, profile_status, profile_invisible, profile_views, profile_change, profile_delete', 'required', 'on'=>'user'),
			array('message_allow, message_inbox, message_outbox', 'required', 'on'=>'message'),
			array('defaults, signup, message_allow, message_inbox, message_outbox, profile_block, profile_search, profile_style, profile_style_sample, profile_status, profile_invisible, profile_views, profile_change, profile_delete, photo_allow, photo_width, photo_height', 'numerical', 'integerOnly'=>true),
			array('name, desc', 'length', 'max'=>11),
			array('profile_privacy, profile_comments, photo_exts,
				title', 'length', 'max'=>32),
			array('creation_date, params', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('level_id, name, desc, defaults, signup, message_allow, message_inbox, message_outbox, profile_block, profile_search, profile_privacy, profile_comments, profile_style, profile_style_sample, profile_status, profile_invisible, profile_views, profile_change, profile_delete, photo_allow, photo_width, photo_height, photo_exts, creation_date,
				title, description', 'safe', 'on'=>'search'),
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
			'title' => array(self::BELONGS_TO, 'OmmuSystemPhrase', 'name'),
			'description' => array(self::BELONGS_TO, 'OmmuSystemPhrase', 'desc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'level_id' => Phrase::trans(16004,1),
			'name' => Phrase::trans(16014,1),
			'desc' => Phrase::trans(16015,1),
			'defaults' => Phrase::trans(16180,1),
			'signup' => Phrase::trans(16132,1),
			'message_allow' => Phrase::trans(16079,1),
			'message_inbox' => Phrase::trans(16133,1),
			'message_outbox' => Phrase::trans(16134,1),
			'profile_block' => Phrase::trans(16058,1),
			'profile_search' => Phrase::trans(16058,1),
			'profile_privacy' => Phrase::trans(16135,1),
			'profile_comments' => Phrase::trans(16136,1),
			'profile_style' => Phrase::trans(16031,1),
			'profile_style_sample' => Phrase::trans(16137,1),
			'profile_status' => Phrase::trans(16038,1),
			'profile_invisible' => Phrase::trans(16042,1),
			'profile_views' => Phrase::trans(16046,1),
			'profile_change' => Phrase::trans(16050,1),
			'profile_delete' => Phrase::trans(16054,1),
			'photo_allow' => Phrase::trans(16021,1),
			'photo_width' => Phrase::trans(16138,1),
			'photo_height' => Phrase::trans(16139,1),
			'photo_exts' => Phrase::trans(16140,1),
			'creation_date' => Phrase::trans(365,0),
			'title' => Phrase::trans(16014,1),
			'description' => Phrase::trans(16015,1),
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

		$criteria->compare('level_id',$this->level_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('defaults',$this->defaults);
		$criteria->compare('signup',$this->signup);
		$criteria->compare('message_allow',$this->message_allow);
		$criteria->compare('message_inbox',$this->message_inbox);
		$criteria->compare('message_outbox',$this->message_outbox);
		$criteria->compare('profile_block',$this->profile_block);
		$criteria->compare('profile_search',$this->profile_search);
		$criteria->compare('profile_privacy',$this->profile_privacy,true);
		$criteria->compare('profile_comments',$this->profile_comments,true);
		$criteria->compare('profile_style',$this->profile_style);
		$criteria->compare('profile_style_sample',$this->profile_style_sample);
		$criteria->compare('profile_status',$this->profile_status);
		$criteria->compare('profile_invisible',$this->profile_invisible);
		$criteria->compare('profile_views',$this->profile_views);
		$criteria->compare('profile_change',$this->profile_change);
		$criteria->compare('profile_delete',$this->profile_delete);
		$criteria->compare('photo_allow',$this->photo_allow);
		$criteria->compare('photo_width',$this->photo_width);
		$criteria->compare('photo_height',$this->photo_height);
		$criteria->compare('photo_exts',$this->photo_exts,true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		
		// Custom Search
		$criteria->with = array(
			'title' => array(
				'alias'=>'title',
				'select'=>'en'
			),
			'description' => array(
				'alias'=>'description',
				'select'=>'en'
			),
		);
		$criteria->compare('title.en',strtolower($this->title), true);
		$criteria->compare('description.en',strtolower($this->description), true);
		
		if(!isset($_GET['UserLevel_sort']))
			$criteria->order = 't.level_id DESC';

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
			//$this->defaultColumns[] = 'level_id';
			$this->defaultColumns[] = 'name';
			$this->defaultColumns[] = 'desc';
			$this->defaultColumns[] = 'defaults';
			$this->defaultColumns[] = 'signup';
			$this->defaultColumns[] = 'message_allow';
			$this->defaultColumns[] = 'message_inbox';
			$this->defaultColumns[] = 'message_outbox';
			$this->defaultColumns[] = 'profile_block';
			$this->defaultColumns[] = 'profile_search';
			$this->defaultColumns[] = 'profile_privacy';
			$this->defaultColumns[] = 'profile_comments';
			$this->defaultColumns[] = 'profile_style';
			$this->defaultColumns[] = 'profile_style_sample';
			$this->defaultColumns[] = 'profile_status';
			$this->defaultColumns[] = 'profile_invisible';
			$this->defaultColumns[] = 'profile_views';
			$this->defaultColumns[] = 'profile_change';
			$this->defaultColumns[] = 'profile_delete';
			$this->defaultColumns[] = 'photo_allow';
			$this->defaultColumns[] = 'photo_width';
			$this->defaultColumns[] = 'photo_height';
			$this->defaultColumns[] = 'photo_exts';
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
			$this->defaultColumns[] = array(
				'name' => 'title',
				'value' => 'Phrase::trans($data->name, 2)',
			);
			$this->defaultColumns[] = array(
				'name' => 'description',
				'value' => 'Phrase::trans($data->desc, 2)',
			);
			$this->defaultColumns[] = array(
				'name' => 'users',
				'value' => '$data->level_id != 1 ? CHtml::link($data->users." ".Phrase::trans(16001, 1), Yii::app()->controller->createUrl("member/manage",array("level"=>$data->level_id))) : CHtml::link($data->users." ".Phrase::trans(16001, 1), Yii::app()->controller->createUrl("admin/manage",array("level"=>$data->level_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'defaults',
				'value' => '$data->defaults == 1 ? Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Utility::getPublish(Yii::app()->controller->createUrl("default",array("id"=>$data->level_id)), $data->defaults, 6)',
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

	//get Default
	public static function getDefault(){
		$model = self::model()->findByAttributes(array('defaults' => 1));
		return $model->level_id;
	}

	//get Type Member (Except administrator)
	public static function getTypeMember($type=null){
		if($type == null) {
			$model = self::model()->findAll(array(
				'condition'=>'level_id != :level',
				'params' => array(
					':level' => 1,
				),
			));
		} else {
			$model = self::model()->findAll();
		}
		$items = array();
		if($model != null) {
			foreach($model as $key => $val) {
				$items[$val->level_id] = Phrase::trans($val->name, 2);
			}
			return $items;
		}else {
			return false;
		}
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$action = strtolower(Yii::app()->controller->action->id);
			if($this->isNewRecord) {
				$currentAction = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id);
				$title=new OmmuSystemPhrase;
				$title->location = $currentAction;
				$title->en = $this->title;
				if($title->save()) {
					$this->name = $title->phrase_id;
				}

				$desc=new OmmuSystemPhrase;
				$desc->location = $currentAction;
				$desc->en = $this->description;
				if($desc->save()) {
					$this->desc = $desc->phrase_id;
				}
			}else {
				if($action == 'edit') {
					$title = OmmuSystemPhrase::model()->findByPk($this->name);
					$title->en = $this->title;
					$title->save();

					$desc = OmmuSystemPhrase::model()->findByPk($this->desc);
					$desc->en = $this->description;
					$desc->save();
				}

				// set to default modules
				if($this->defaults == 1) {
					self::model()->updateAll(array(
						'defaults' => 0,	
					));
					$this->defaults = 1;
				}
			}
		}
		return true;
	}
}