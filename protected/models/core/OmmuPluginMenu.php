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
 * This is the model class for table "ommu_core_plugin_menu".
 *
 * The followings are the available columns in table 'ommu_core_plugin_menu':
 * @property integer $menu_id
 * @property string $module
 * @property integer $enabled
 * @property integer $orders
 * @property integer $name
 * @property string $icon
 * @property string $url
 * @property integer $dialog
 * @property string $attr
 * @property string $creation_date
 */
class OmmuPluginMenu extends CActiveRecord
{
	public $defaultColumns = array();
	public $title;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OmmuPluginMenu the static model class
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
		return 'ommu_core_plugin_menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('module, url,
				title', 'required'),
			array('enabled, orders, name, dialog', 'numerical', 'integerOnly'=>true),
			array('icon', 'length', 'max'=>16),
			array('module,
				title', 'length', 'max'=>32),
			array('url, attr', 'length', 'max'=>128),
			array('creation_date,
				title', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('menu_id, module, enabled, orders, name, icon, url, dialog, attr,
				title', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'menu_id' => Phrase::trans(445,0),
			'module' => Phrase::trans(135,0),
			'enabled' => Phrase::trans(61,0),
			'orders' => Phrase::trans(202,0),
			'name' => Phrase::trans(194,0),
			'icon' => Phrase::trans(195,0),
			'url' => Phrase::trans(197,0),
			'dialog' => Phrase::trans(198,0),
			'attr' => Phrase::trans(203,0),
			'title' => Phrase::trans(194,0),
			'creation_date' => Phrase::trans(365,0),
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

		$criteria->compare('t.menu_id',$this->menu_id);
		if(isset($_GET['module'])) {
			$criteria->compare('t.module',$_GET['module']);
		} else {			
			$criteria->compare('t.module',$this->module);
		}
		$criteria->compare('t.enabled',$this->enabled);
		$criteria->compare('t.orders',$this->orders);
		$criteria->compare('t.name',$this->name);
		$criteria->compare('t.icon',$this->icon,true);
		$criteria->compare('t.url',strtolower($this->url),true);
		$criteria->compare('t.dialog',$this->dialog);
		$criteria->compare('t.attr',$this->attr,true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		
		// Custom Search
		$criteria->with = array(
			'title' => array(
				'alias'=>'title',
				'select'=>'en'
			),
		);
		$criteria->compare('title.en',strtolower($this->title), true);
		
		if(!isset($_GET['OmmuPluginMenu_sort']))
			$criteria->order = 'menu_id DESC';

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
			//$this->defaultColumns[] = 'menu_id';
			$this->defaultColumns[] = 'module';
			$this->defaultColumns[] = 'enabled';
			$this->defaultColumns[] = 'orders';
			$this->defaultColumns[] = 'name';
			$this->defaultColumns[] = 'icon';
			$this->defaultColumns[] = 'url';
			$this->defaultColumns[] = 'dialog';
			$this->defaultColumns[] = 'attr';
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
			if(!isset($_GET['module'])) {
				$this->defaultColumns[] = 'module';
			}
			$this->defaultColumns[] = array(
				'name' => 'url',
				'value' => '$data->module."/".$data->url',
			);
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
			$this->defaultColumns[] = array(
				'name' => 'dialog',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("dialog",array("id"=>$data->menu_id)), $data->dialog, 4)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>Phrase::trans(588,0),
					0=>Phrase::trans(589,0),
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'enabled',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("enable",array("id"=>$data->menu_id)), $data->enabled, 3)',
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
		if(parent::beforeValidate()) {		
			if($this->isNewRecord) {
				$this->orders = 1;
			}		
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$action = strtolower(Yii::app()->controller->action->id);
			if($this->isNewRecord) {
				$current = strtolower(Yii::app()->controller->id);
				$title=new OmmuSystemPhrase;
				$title->phrase_id = count(OmmuSystemPhrase::getAdminPhrase('phrase_id')) + 1;
				$title->location = $current;
				$title->en = $this->title;
				if($title->save()) {
					$this->name = $title->phrase_id;
				}
			}else {
				if($action == 'edit') {
					$title = OmmuSystemPhrase::model()->findByPk($this->name);
					$title->en = $this->title;
					$title->save();
				}
			}
		}
		return true;
	}
}