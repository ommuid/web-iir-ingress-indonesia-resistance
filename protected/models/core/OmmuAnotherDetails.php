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
 * This is the model class for table "ommu_core_another_details".
 *
 * The followings are the available columns in table 'ommu_core_another_details':
 * @property string $another_id
 * @property integer $publish
 * @property integer $type
 * @property string $user_id
 * @property string $another
 * @property string $address
 * @property string $website
 * @property string $acreditation
 * @property string $creation_date
 */
class OmmuAnotherDetails extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $user_search;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OmmuAnotherDetails the static model class
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
		return 'ommu_core_another_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('another', 'required'),
			array('address, website', 'required', 'on'=>'anotherdetail'),
			array('publish, type', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('another', 'length', 'max'=>64),
			array('website', 'length', 'max'=>128),
			array('acreditation', 'length', 'max'=>32),
			array('type, user_id, address, website, acreditation, creation_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('another_id, publish, type, user_id, another, address, website, acreditation, creation_date,
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
			'another_id' => Phrase::trans(397,0),
			'publish' => Phrase::trans(192,0),
			'type' => Phrase::trans(398,0),
			'user_id' => Phrase::trans(369,0),
			'another' => Phrase::trans(397,0),
			'address' => Phrase::trans(399,0),
			'website' => Phrase::trans(364,0),
			'acreditation' => Phrase::trans(400,0),
			'creation_date' => Phrase::trans(365,0),
			'user_search' => Phrase::trans(369,0),
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

		$criteria->compare('t.another_id',$this->another_id);
		if(isset($_GET['type']) && $_GET['type'] == 'publish') {
			$criteria->compare('t.publish',1);
		} elseif(isset($_GET['type']) && $_GET['type'] == 'unpublish') {
			$criteria->compare('t.publish',0);
		} elseif(isset($_GET['type']) && $_GET['type'] == 'trash') {
			$criteria->compare('t.publish',2);
		} else {
			$criteria->addInCondition('t.publish',array(0,1));
			$criteria->compare('t.publish',$this->publish);
		}
		$criteria->compare('t.type',$this->type);
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.another',strtolower($this->another),true);
		$criteria->compare('t.address',strtolower($this->address),true);
		$criteria->compare('t.website',strtolower($this->website),true);
		$criteria->compare('t.acreditation',$this->acreditation,true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		
		// Custom Search
		$criteria->with = array(
			'user' => array(
				'alias'=>'user',
				'select'=>'displayname'
			),
		);
		$criteria->compare('user.displayname',strtolower($this->user_search), true);

		if(!isset($_GET['OmmuAnotherDetails_sort'])) {
			$criteria->order = 'another_id DESC';
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
			//$this->defaultColumns[] = 'another_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'type';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'another';
			$this->defaultColumns[] = 'address';
			$this->defaultColumns[] = 'website';
			$this->defaultColumns[] = 'acreditation';
			$this->defaultColumns[] = 'creation_date';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			/*
			$this->defaultColumns[] = array(
				'class' => 'CCheckBoxColumn',
				'name' => 'id',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'trash_id[]')
			);
			*/
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			$this->defaultColumns[] = array(
				'name' => 'another',
				'value' => '$data->type != 0 ? $data->another."<br/><span>".$data->acreditation."</span>" : $data->another',
				'htmlOptions' => array(
					'class' => 'bold',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = 'address';
			$this->defaultColumns[] = 'website';
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
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->another_id)), $data->publish, 1)',
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

		}
		parent::afterConstruct();
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		$controller = strtolower(Yii::app()->controller->id);
		if(parent::beforeValidate()) {		
			if($this->isNewRecord) {
				$this->user_id = Yii::app()->user->id;
			}
			if($controller == 'anotherdetail' && $this->type != 0) {
				if($this->acreditation == '') {
					$this->addError('acreditation', Phrase::trans(409,0));
				}
			}
		}
		return true;
	}

}