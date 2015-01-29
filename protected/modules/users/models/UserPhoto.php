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
 * This is the model class for table "ommu_user_photo".
 *
 * The followings are the available columns in table 'ommu_user_photo':
 * @property string $photo_id
 * @property string $user_id
 * @property integer $orders
 * @property integer $cover
 * @property string $photo
 * @property string $creation_date
 */
class UserPhoto extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserPhoto the static model class
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
		return 'ommu_user_photo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, photo', 'required'),
			array('orders, cover', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('photo', 'length', 'max'=>64),
			array('cover, creation_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('photo_id, user_id, orders, cover, photo, creation_date', 'safe', 'on'=>'search'),
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
			'photo_id' => Phrase::trans(16151,1),
			'user_id' => Phrase::trans(16001,1),
			'orders' => Phrase::trans(16170,1),
			'cover' => Phrase::trans(16171,1),
			'photo' => Phrase::trans(16151,1),
			'creation_date' => Phrase::trans(16160,1),
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

		$criteria->compare('photo_id',$this->photo_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('orders',$this->orders);
		$criteria->compare('cover',$this->cover);
		$criteria->compare('photo',$this->photo,true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
			
		if(!isset($_GET['UserPhoto_sort']))
			$criteria->order = 'photo_id DESC';

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
			//$this->defaultColumns[] = 'photo_id';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'orders';
			$this->defaultColumns[] = 'cover';
			$this->defaultColumns[] = 'photo';
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
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'orders';
			$this->defaultColumns[] = 'cover';
			$this->defaultColumns[] = 'photo';
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Utility::dateFormat($data->creation_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this, 
					'attribute'=>'creation_date', 
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
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
	 * get photo product
	 */
	public static function getPhoto($id, $type=null) {
		if($type == null) {
			$model = self::model()->findAll(array(
				//'select' => 'user_id, orders, media',
				'condition' => 'user_id = :id',
				'params' => array(
					':id' => $id,
				),
				//'order'=> 'orders ASC',
			));
			
		} else {
			$model = self::model()->findAll(array(
				//'select' => 'user_id, orders, media',
				'condition' => 'user_id = :id AND cover = :cover',
				'params' => array(
					':id' => $id,
					':cover' => $type,
				),
				//'order'=> 'orders ASC',
			));
		}

		return $model;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			// set to default modules
			if(self::getPhoto($this->user_id) == null) {
				$this->cover = 1;
			}
			if($this->cover == 1) {
				self::model()->updateAll(array(
					'cover' => 0,	
				),array(
					'condition'=> 'user_id = :id',
					'params'=>array(':id'=>$this->user_id),
				));
				$this->cover = 1;
			}
		}
		return true;
	}
	
	
	/**
	 * After save attributes
	 */
	protected function afterSave() {
		parent::afterSave();
		//set photo cover in user
		if($this->cover == 1) {
			$user = Users::model()->findByPk($this->user_id);
			$user->photo_id = $this->photo_id;
			$user->update();
		}

		//create thumb image
		Yii::import('ext.phpthumb.PhpThumbFactory');
		$user_path = "public/users/".$this->user_id;
		$userImg = PhpThumbFactory::create($user_path.'/'.$this->photo, array('jpegQuality' => 90, 'correctPermissions' => true));
		//$userImg->adaptiveResize(700, 1200);
		$userImg->resize(700);
		$userImg->save($user_path.'/'.$this->photo);
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() {
		parent::afterDelete();
		//delete user photo
		$user_path = "public/users/".$this->user_id;
		rename($user_path.'/'.$this->photo, 'public/users/verwijderen/'.$this->user_id.'_'.$this->photo);

		$data = self::getPhoto($this->user_id);

		if($data == null) {
			$cover = Users::model()->findByPk($this->user_id);
			$cover->photo_id = 0;
			$cover->update();
		} else {
			if($this->cover == 1) {	
				$photo = self::model()->findByPk($data[0]->photo_id);
				$photo->cover = 1;
				if($photo->update()) {
					$cover = Users::model()->findByPk($this->user_id);
					$cover->photo_id = $photo->photo_id;
					$cover->update();
				}
			}
		}
	}

}