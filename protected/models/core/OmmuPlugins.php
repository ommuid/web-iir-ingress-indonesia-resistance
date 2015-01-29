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
 * This is the model class for table "ommu_core_plugins".
 *
 * The followings are the available columns in table 'ommu_core_plugins':
 * @property integer $plugin_id
 * @property integer $defaults
 * @property integer $install
 * @property integer $actived
 * @property integer $orders
 * @property string $folder
 * @property integer $code
 * @property string $model
 * @property string $name
 * @property string $desc
 * @property string $version
 * @property string $icon
 * @property string $creation_date
 *
 * The followings are the available model relations:
 * @property OmmuCoreComment[] $ommuCoreComments
 * @property OmmuCorePluginPhrase[] $ommuCorePluginPhrases
 */
class OmmuPlugins extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OmmuPlugins the static model class
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
		return 'ommu_core_plugins';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('folder', 'required'),
			array('name, desc', 'required', 'on'=>'adminadd'),
			array('defaults, install, actived, orders, code', 'numerical', 'integerOnly'=>true),
			array('folder, model', 'length', 'max'=>32),
			array('name', 'length', 'max'=>128),
			array('desc', 'length', 'max'=>255),
			array('version, icon', 'length', 'max'=>16),
			array('creation_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('plugin_id, defaults, install, actived, orders, folder, code, model, name, desc, version, icon, creation_date', 'safe', 'on'=>'search'),
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
			'plugin_id' => Phrase::trans(161,0),
			'defaults' => Phrase::trans(156,0),
			'install' => Phrase::trans(499,0),
			'actived' => Phrase::trans(231,0),
			'orders' => Phrase::trans(202,0),
			'folder' => Phrase::trans(429,0),
			'code' => Phrase::trans(238,0),
			'model' => Phrase::trans(442,0),
			'name' => Phrase::trans(235,0),
			'desc' => Phrase::trans(236,0),
			'version' =>  Phrase::trans(237,0),
			'icon' => Phrase::trans(239,0),
			'creation_date' => Phrase::trans(443,0),
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

		$criteria->compare('t.plugin_id',$this->plugin_id);
		$criteria->compare('t.defaults',$this->defaults);
		$criteria->compare('t.install',$this->install);
		if(isset($_GET['type']) && $_GET['type'] == 'all') {
			$criteria->compare('t.actived',$this->actived);
		} else {
			$criteria->addInCondition('t.actived',array(1,2));
			$criteria->compare('t.actived',$this->actived);
		}
		$criteria->compare('t.orders',$this->orders);
		$criteria->compare('t.folder',strtolower($this->folder),true);
		$criteria->compare('t.code',$this->code);
		$criteria->compare('t.model',strtolower($this->model),true);
		$criteria->compare('t.name',strtolower($this->name),true);
		$criteria->compare('t.desc',strtolower($this->desc),true);
		$criteria->compare('t.version',strtolower($this->version),true);
		$criteria->compare('t.icon',$this->icon,true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		
		if(!isset($_GET['OmmuPlugins_sort']))
			$criteria->order = 'plugin_id DESC';

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
			//$this->defaultColumns[] = 'plugin_id';
			$this->defaultColumns[] = 'defaults';
			$this->defaultColumns[] = 'install';
			$this->defaultColumns[] = 'actived';
			$this->defaultColumns[] = 'orders';
			$this->defaultColumns[] = 'folder';
			$this->defaultColumns[] = 'code';
			$this->defaultColumns[] = 'model';
			$this->defaultColumns[] = 'name';
			$this->defaultColumns[] = 'desc';
			$this->defaultColumns[] = 'version';
			$this->defaultColumns[] = 'icon';
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
			$this->defaultColumns[] = 'folder';
			$this->defaultColumns[] = array(
				'name' => 'name',
				'value' => '$data->name == "" ? "-" : $data->name',
			);
			$this->defaultColumns[] = array(
				'name' => 'desc',
				'value' => '$data->desc == "" ? "-" : $data->desc',
			);
			$this->defaultColumns[] = array(
				'name' => 'version',
				'value' => '$data->version',
				'htmlOptions' => array(
					'class' => 'center',
				),
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
				'name' => 'install',
				'value' => '$data->install == 1 ? Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Utility::getPublish(Yii::app()->controller->createUrl("install",array("id"=>$data->plugin_id)), $data->install, 10)',
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
				'name' => 'actived',
				'value' => '$data->install == 1 ? ($data->actived == 2 ? Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Utility::getPublish(Yii::app()->controller->createUrl("active",array("id"=>$data->plugin_id)), $data->actived, 2)) : "-"',
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
				'name' => 'defaults',
				'value' => '$data->install == 1 ? ($data->defaults == 1 ? Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Utility::getPublish(Yii::app()->controller->createUrl("default",array("id"=>$data->plugin_id)), $data->defaults, 6)) : "-"',
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

	// Get plugin list
	public static function getPlugin($actived=null) {
		if($actived == null) {
			$model = self::model()->findAll(array('order' => 'folder ASC'));
			
		} else if($actived == 0) {
			$model = self::model()->findAll(array(
				'select' => 'plugin_id, folder, code, name',
				'condition' => 'actived != :actived',
				'params' => array(
					':actived' => 0,
				),
				'order'=> 'folder ASC',
			));
			
		} else {
			$model = self::model()->findAll(array(
				'select' => 'plugin_id, folder, code, name',
				'condition' => 'actived = :actived',
				'params' => array(
					':actived' => $actived,
				),
				'order'=> 'orders ASC',
			));
		}
		return $model;
	}

	// Get plugin if condition active
	public static function getPluginArray($type, $actived=null) {
		if($actived == null) {
			$model = self::getPlugin();
		} else {
			$model = self::getPlugin($actived);
		}		
		$items = array();
		if($model != null) {
			foreach($model as $key => $val) {
				if($type == 'id') {
					$items[$val->plugin_id] = $val->name;			
				} else {
					$items[$val->folder] = $val->name;		
				}
			}
			return $items;
		}else {
			return false;
		}
	}

	// Get plugin code
	public static function getPluginCode($id){
		$model = self::model()->findByPk($id);
		return $model->code;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {		
			if($this->isNewRecord) {
				if($this->actived == 1) {
					$this->orders = count(self::getPlugin(1)) + 1;
				} else {
					$this->orders = 0;
				}
				$this->version = '1.0';
			}		
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			if(!$this->isNewRecord) {
				if($this->actived == 0) {
					$conn = Yii::app()->db;
					$sql = "UPDATE ommu_core_plugins SET orders = (orders - 1) WHERE orders > {$this->orders}";
					$conn->createCommand($sql)->execute();
					$this->orders = 0;
				} else if($this->actived == 1) {
					$this->orders = count(self::getPlugin(1)) + 1;
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