<?php
/**
 * ArticleCategory
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Articles
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
 * This is the model class for table "ommu_article_category".
 *
 * The followings are the available columns in table 'ommu_article_category':
 * @property integer $cat_id
 * @property integer $publish
 * @property integer $parent
 * @property string $name
 * @property string $desc
 * @property string $single_photo
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuArticles[] $ommuArticles
 */
class ArticleCategory extends CActiveRecord
{
	public $defaultColumns = array();
	public $title_i;
	public $description_i;
	
	// Variable Search
	public $creation_search;
	public $modified_search;

	/**
	 * Behaviors for this model
	 */
	public function behaviors() 
	{
		return array(
			'sluggable' => array(
				'class'=>'ext.yii-behavior-sluggable.SluggableBehavior',
				'columns' => array('title.en_us'),
				'unique' => true,
				'update' => true,
			),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ArticleCategory the static model class
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
		return 'ommu_article_category';
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
				title_i, description_i', 'required'),
			array('publish, parent, single_photo, creation_id, modified_id', 'numerical', 'integerOnly'=>true),
			array('name, desc, creation_id, modified_id', 'length', 'max'=>11),
			array('
				title_i', 'length', 'max'=>32),
			array('
				description_i', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cat_id, publish, parent, name, desc, single_photo, creation_date, creation_id, modified_date, modified_id,
				title_i, description_i, creation_search, modified_search', 'safe', 'on'=>'search'),
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
			'view' => array(self::BELONGS_TO, 'ViewArticleCategory', 'cat_id'),
			'title' => array(self::BELONGS_TO, 'OmmuSystemPhrase', 'name'),
			'description' => array(self::BELONGS_TO, 'OmmuSystemPhrase', 'desc'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			'articles' => array(self::BELONGS_TO, 'Articles', 'article_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cat_id' => Yii::t('attribute', 'Category'),
			'publish' => Yii::t('attribute', 'Publish'),
			'parent' => Yii::t('attribute', 'Parent'),
			'name' => Yii::t('attribute', 'Category'),
			'desc' => Yii::t('attribute', 'Description'),
			'single_photo' => Yii::t('attribute', 'Single Photo'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'title_i' => Yii::t('attribute', 'Category'),
			'description_i' => Yii::t('attribute', 'Description'),
			'creation_search' => Yii::t('attribute', 'Creation'),
			'modified_search' => Yii::t('attribute', 'Modified'),
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
		
		// Custom Search
		$defaultLang = OmmuLanguages::getDefault('code');
		if(isset(Yii::app()->session['language']))
			$language = Yii::app()->session['language'];
		else 
			$language = $defaultLang;
		
		$criteria->with = array(
			'view' => array(
				'alias'=>'view',
			),
			'title' => array(
				'alias'=>'title',
				'select'=>$language,
			),
			'description' => array(
				'alias'=>'description',
				'select'=>$language,
			),
			'creation' => array(
				'alias'=>'creation',
				'select'=>'displayname'
			),
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname'
			),
		);

		$criteria->compare('t.cat_id',$this->cat_id);
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
		$criteria->compare('t.parent',$this->parent);
		$criteria->compare('t.name',$this->name);
		$criteria->compare('t.desc',$this->desc);
		$criteria->compare('t.single_photo',$this->single_photo);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_id',$this->creation_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id',$this->modified_id);
		
		$criteria->compare('title.'.$language,strtolower($this->title_i), true);
		$criteria->compare('description.'.$language,strtolower($this->description_i), true);
		$criteria->compare('creation.displayname',strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname',strtolower($this->modified_search), true);

		if(!isset($_GET['ArticleCategory_sort']))
			$criteria->order = 't.cat_id DESC';

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
			//$this->defaultColumns[] = 'cat_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'parent';
			$this->defaultColumns[] = 'name';
			$this->defaultColumns[] = 'desc';
			$this->defaultColumns[] = 'single_photo';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_id';
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
				'name' => 'title_i',
				'value' => 'Phrase::trans($data->name)',
			);
			$this->defaultColumns[] = array(
				'name' => 'description_i',
				'value' => 'Phrase::trans($data->desc)',
			);
			$this->defaultColumns[] = array(
				'name' => 'parent',
				'value' => '$data->parent != 0 ? Phrase::trans(ArticleCategory::model()->findByPk($data->parent)->name) : "-"',
			);
			$this->defaultColumns[] = array(
				'header' => Yii::t('phrase', 'Articles'),
				'value' => 'CHtml::link($data->view->articles ? $data->view->articles : 0, Yii::app()->controller->createUrl("o/admin/manage",array("category"=>$data->cat_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_search',
				'value' => '$data->creation->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Utility::dateFormat($data->creation_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.components.system.CJuiDatePicker', array(
					'model'=>$this, 
					'attribute'=>'creation_date', 
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
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
				'name' => 'single_photo',
				'value' => '$data->single_photo == 1 ? Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/unpublish.png\')',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>Yii::t('phrase', 'Yes'),
					0=>Yii::t('phrase', 'No'),
				),
				'type' => 'raw',
			);
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("o/category/publish",array("id"=>$data->cat_id)), $data->publish, 1)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Yii::t('phrase', 'Yes'),
						0=>Yii::t('phrase', 'No'),
					),
					'type' => 'raw',
				);
			}
		}
		parent::afterConstruct();
	}

	/**
	 * Get category
	 * 0 = unpublish
	 * 1 = publish
	 */
	public static function getCategory($publish=null, $parent=null, $type=null) 
	{
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		
		$criteria=new CDbCriteria;
		if($publish != null)
			$criteria->compare('publish',$publish);
		if($parent != null)
			$criteria->compare('parent',$parent);
		
		$model = self::model()->findAll($criteria);

		if($type == null) {
			$items = array();
			if($model != null) {
				foreach($model as $key => $val) {
					if($currentAction == 'o/setting/edit' && $val->parent != 0)
						$items[$val->cat_id] = Phrase::trans(ArticleCategory::model()->findByPk($val->parent)->name).' / '.Phrase::trans($val->name);
					else
						$items[$val->cat_id] = Phrase::trans($val->name);
				}
				return $items;
				
			} else
				return false;
			
		} else if($type == 'data')
			return $model;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {		
			if($this->isNewRecord)
				$this->creation_id = Yii::app()->user->id;	
			else
				$this->modified_id = Yii::app()->user->id;
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() 
	{
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		$location = Utility::getUrlTitle($currentAction);
		
		if(parent::beforeSave()) {
			if($this->isNewRecord || (!$this->isNewRecord && $this->name == 0)) {
				$title=new OmmuSystemPhrase;
				$title->location = $location.'_title';
				$title->en_us = $this->title_i;
				if($title->save())
					$this->name = $title->phrase_id;
				
				$this->slug = Utility::getUrlTitle($this->title_i);	
				
			} else {
				$title = OmmuSystemPhrase::model()->findByPk($this->name);
				$title->en_us = $this->title_i;
				$title->save();
			}
			
			if($this->isNewRecord || (!$this->isNewRecord && $this->desc == 0)) {
				$desc=new OmmuSystemPhrase;
				$desc->location = $location.'_description';
				$desc->en_us = $this->description_i;
				if($desc->save())
					$this->desc = $desc->phrase_id;
				
			} else {
				$desc = OmmuSystemPhrase::model()->findByPk($this->desc);
				$desc->en_us = $this->description_i;
				$desc->save();
				
			}
		}
		return true;
	}

}