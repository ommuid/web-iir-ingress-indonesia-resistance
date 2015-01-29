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
 * This is the model class for table "ommu_core_themes".
 *
 * The followings are the available columns in table 'ommu_core_themes':
 * @property integer $theme_id
 * @property string $group_page
 * @property integer $default_theme
 * @property string $folder
 * @property string $layout
 * @property string $name
 * @property string $thumbnail
 */
class OmmuThemes extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OmmuThemes the static model class
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
		return 'ommu_core_themes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_page, folder, layout, name', 'required'),
			array('default_theme', 'numerical', 'integerOnly'=>true),
			array('group_page', 'length', 'max'=>6),
			array('folder, layout, name, thumbnail', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('theme_id, group_page, default_theme, folder, layout, name, thumbnail', 'safe', 'on'=>'search'),
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
			'theme_id' => Phrase::trans(428,0),
			'group_page' => Phrase::trans(234,0),
			'default_theme' => Phrase::trans(156,0),
			'folder' => Phrase::trans(429,0),
			'layout' => Phrase::trans(430,0),
			'name' => Phrase::trans(232,0),
			'thumbnail' => Phrase::trans(233,0),
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

		$criteria->compare('t.theme_id',$this->theme_id);
		$criteria->compare('t.group_page',$this->group_page,true);
		$criteria->compare('t.default_theme',$this->default_theme);
		$criteria->compare('t.folder',strtolower($this->folder),true);
		$criteria->compare('t.layout',strtolower($this->layout),true);
		$criteria->compare('t.name',strtolower($this->name),true);
		$criteria->compare('t.thumbnail',$this->thumbnail,true);
		
		if(!isset($_GET['OmmuThemes_sort']))
			$criteria->order = 'theme_id DESC';

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
			//$this->defaultColumns[] = 'theme_id';
			$this->defaultColumns[] = 'group_page';
			$this->defaultColumns[] = 'default_theme';
			$this->defaultColumns[] = 'folder';
			$this->defaultColumns[] = 'layout';
			$this->defaultColumns[] = 'name';
			$this->defaultColumns[] = 'thumbnail';
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
			$this->defaultColumns[] = 'name';
			$this->defaultColumns[] = 'folder';
			$this->defaultColumns[] = array(
				'name' => 'group_page',
				'value' => '$data->group_page',
				'htmlOptions' => array(
					//'class' => 'center',
				),
				'filter'=>array(
					'admin'=>Phrase::trans(590,0),
					'public'=>Phrase::trans(229,0),
					'underconstruction'=>Phrase::trans(591,0),
					'maintenance'=>Phrase::trans(592,0),
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'default_theme',
				'value' => '$data->default_theme == 1 ? Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Utility::getPublish(Yii::app()->controller->createUrl("default",array("id"=>$data->theme_id)), $data->default_theme, 6)',
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
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			if(!$this->isNewRecord) {
				// set to default modules
				if($this->default_theme == 1) {
					self::model()->updateAll(array(
						'default_theme' => 0,	
					), array(
						'condition'=> 'group_page = :group',
						'params'=>array(':group'=>$this->group_page),
					));
					$this->default_theme = 1;
				}
			}
		}
		return true;
	}

}