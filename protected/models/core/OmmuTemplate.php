<?php
/**
 * OmmuTemplate
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
 * This is the model class for table "ommu_core_template".
 *
 * The followings are the available columns in table 'ommu_core_template':
 * @property string $template_key
 * @property integer $plugin_id
 * @property string $user_id
 * @property string $template
 * @property string $variable
 * @property string $creation_date
 * @property string $modified_date
 * @property string $modified_id
 */
class OmmuTemplate extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $user_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OmmuTemplate the static model class
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
		return 'ommu_core_template';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('template_key, plugin_id, template, variable', 'required'),
			array('plugin_id', 'numerical', 'integerOnly'=>true),
			array('template_key', 'length', 'max'=>32),
			array('user_id, modified_id', 'length', 'max'=>11),
			array('modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('template_key, plugin_id, user_id, template, variable, creation_date, modified_date, modified_id,
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
			'plugin' => array(self::BELONGS_TO, 'OmmuPlugins', 'plugin_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'template_key' => 'Template Key',
			'plugin_id' => Phrase::trans(161,0),
			'user_id' => Phrase::trans(191,0),
			'template' => 'Template',
			'variable' => 'Variable',
			'creation_date' => Phrase::trans(365,0),
			'modified_date' => Phrase::trans(446,0),
			'modified_id' => 'Modified',
			'user_search' => Phrase::trans(191,0),
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

		$criteria->compare('t.template_key',$this->template_key,true);
		$criteria->compare('t.plugin_id',$this->plugin_id);
		if(isset($_GET['user'])) {
			$criteria->compare('t.user_id',$_GET['user']);
		} else {
			$criteria->compare('t.user_id',$this->user_id);
		}
		$criteria->compare('t.template',$this->template,true);
		$criteria->compare('t.variable',$this->variable,true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		if(isset($_GET['modified'])) {
			$criteria->compare('t.modified_id',$_GET['modified']);
		} else {
			$criteria->compare('t.modified_id',$this->modified_id);
		}
		
		// Custom Search
		$criteria->with = array(
			'user' => array(
				'alias'=>'user',
				'select'=>'displayname'
			),
		);
		$criteria->compare('user.displayname',strtolower($this->user_search), true);

		if(!isset($_GET['OmmuTemplate_sort']))
			$criteria->order = 'template_key DESC';

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
			//$this->defaultColumns[] = 'template_key';
			$this->defaultColumns[] = 'plugin_id';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'template';
			$this->defaultColumns[] = 'variable';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'modified_date';
			$this->defaultColumns[] = 'modified_id';
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
				'name' => 'plugin_id',
				'value' => '$data->plugin->name',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>OmmuPlugins::getPluginArray('id', 0),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'template_key',
				'value' => '$data->template_key',
			);
			//$this->defaultColumns[] = 'template';
			$this->defaultColumns[] = 'variable';
			$this->defaultColumns[] = array(
				'name' => 'user_search',
				'value' => '$data->user->displayname',
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
	public static function getMessage($template_key, $other=null)
	{
		$model = self::model()->findByPk($template_key);
		
		if(!empty($other)) {
			$replace = array();
			$search = array();
			$i = 0;
			foreach($other as $label=>$url) {
				$i++;
				if(is_string($label) || is_array($url))
					//$replace[] = CHtml::link($this->getEncodeLabel() ? CHtml::encode($label) : $label, $url, array('title'=>$label));
					$replace[] = CHtml::link($label, $url, array('title'=>$label));
				else
					//$replace[] = $this->getEncodeLabel() ? CHtml::encode($url) : $url;
					$replace[] = $url;
				$search[] = '$'.$i.'';
			}
			$message = str_replace($search, $replace, $model->template);
			
		} else
			$message = $model->template;
		
		return $message;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {	
			if($this->isNewRecord) {
				$this->user_id = Yii::app()->user->id;
			} else {
				$this->modified_id = Yii::app()->user->id;	
			}
		}
		return true;
	}

}