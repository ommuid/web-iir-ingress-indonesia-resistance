<?php
/**
 * ViewBannerStatistics
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 8 January 2017, 19:19 WIB
 * @link https://github.com/ommu/mod-banner
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
 * This is the model class for table "_view_banner_statistics".
 *
 * The followings are the available columns in table '_view_banner_statistics':
 * @property string $date_key
 * @property string $category_insert
 * @property string $category_update
 * @property string $category_delete
 * @property string $banner_insert
 * @property string $banner_update
 * @property string $banner_delete
 * @property string $banner_views
 * @property string $banner_click
 * @property string $setting_update
 */
class ViewBannerStatistics extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewBannerStatistics the static model class
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
		return '_view_banner_statistics';
	}

	/**
	 * @return string the primarykey column
	 */
	public function primaryKey()
	{
		return 'date_key';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_insert, category_update, category_delete, banner_insert, banner_update, banner_delete, banner_views, banner_click, setting_update', 'length', 'max'=>23),
			array('date_key', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('date_key, category_insert, category_update, category_delete, banner_insert, banner_update, banner_delete, banner_views, banner_click, setting_update', 'safe', 'on'=>'search'),
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
			'date_key' => Yii::t('attribute', 'Date Key'),
			'category_insert' => Yii::t('attribute', 'Category Insert'),
			'category_update' => Yii::t('attribute', 'Category Update'),
			'category_delete' => Yii::t('attribute', 'Category Delete'),
			'banner_insert' => Yii::t('attribute', 'Banner Insert'),
			'banner_update' => Yii::t('attribute', 'Banner Update'),
			'banner_delete' => Yii::t('attribute', 'Banner Delete'),
			'banner_views' => Yii::t('attribute', 'Banner Views'),
			'banner_click' => Yii::t('attribute', 'Banner Click'),
			'setting_update' => Yii::t('attribute', 'Setting Update'),
		);
		/*
			'Date Key' => 'Date Key',
			'Category Insert' => 'Category Insert',
			'Category Update' => 'Category Update',
			'Category Delete' => 'Category Delete',
			'Banner Insert' => 'Banner Insert',
			'Banner Update' => 'Banner Update',
			'Banner Delete' => 'Banner Delete',
			'Banner Views' => 'Banner Views',
			'Banner Click' => 'Banner Click',
			'Setting Update' => 'Setting Update',
		
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

		if($this->date_key != null && !in_array($this->date_key, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.date_key)',date('Y-m-d', strtotime($this->date_key)));
		$criteria->compare('t.category_insert',strtolower($this->category_insert),true);
		$criteria->compare('t.category_update',strtolower($this->category_update),true);
		$criteria->compare('t.category_delete',strtolower($this->category_delete),true);
		$criteria->compare('t.banner_insert',strtolower($this->banner_insert),true);
		$criteria->compare('t.banner_update',strtolower($this->banner_update),true);
		$criteria->compare('t.banner_delete',strtolower($this->banner_delete),true);
		$criteria->compare('t.banner_views',strtolower($this->banner_views),true);
		$criteria->compare('t.banner_click',strtolower($this->banner_click),true);
		$criteria->compare('t.setting_update',strtolower($this->setting_update),true);

		if(!isset($_GET['ViewBannerStatistics_sort']))
			$criteria->order = 't.date_key DESC';

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
			$this->defaultColumns[] = 'date_key';
			$this->defaultColumns[] = 'category_insert';
			$this->defaultColumns[] = 'category_update';
			$this->defaultColumns[] = 'category_delete';
			$this->defaultColumns[] = 'banner_insert';
			$this->defaultColumns[] = 'banner_update';
			$this->defaultColumns[] = 'banner_delete';
			$this->defaultColumns[] = 'banner_views';
			$this->defaultColumns[] = 'banner_click';
			$this->defaultColumns[] = 'setting_update';
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
				'name' => 'date_key',
				'value' => 'Utility::dateFormat($data->date_key)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'date_key',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'date_key_filter',
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
			$this->defaultColumns[] = 'category_insert';
			$this->defaultColumns[] = 'category_update';
			$this->defaultColumns[] = 'category_delete';
			$this->defaultColumns[] = 'banner_insert';
			$this->defaultColumns[] = 'banner_update';
			$this->defaultColumns[] = 'banner_delete';
			$this->defaultColumns[] = 'banner_views';
			$this->defaultColumns[] = 'banner_click';
			$this->defaultColumns[] = 'setting_update';
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